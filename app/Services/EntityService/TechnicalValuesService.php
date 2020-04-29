<?php

namespace App\Services\EntityService;

use App\Models\Date;
use App\Models\Pollutant;
use App\Models\TechnicalValues;
use App\Repositories\Contracts\QualityRepository;
use App\Repositories\Contracts\TechnicalValuesRepository;
use App\Services\EntityService\Contracts\TechnicalValuesService as TechnicalServiceInterface;
use Illuminate\Database\DatabaseManager;
use Illuminate\Log\Logger;
use Exception;

/**
 * Class TechnicalValuesService
 *
 * @package App\Services\EntityService
 * @method bool destroy
 */
class TechnicalValuesService  extends BaseService implements TechnicalServiceInterface
{
    /**
     * @var DatabaseManager $databaseManager
     */
    protected $databaseManager;

    /**
     * @var TechnicalValuesRepository $repository
     */
    protected $repository;

    /**
     * @var Logger $logger
     */
    protected $logger;

    /**
     * @var QualityRepository $qualityRepository
     */
    protected $qualityRepository;

    /**
     * TechnicalValuesService constructor.
     *
     * @param DatabaseManager $databaseManager
     * @param TechnicalValuesRepository $repository
     * @param Logger $logger
     */
    public function __construct(
        DatabaseManager $databaseManager,
        TechnicalValuesRepository $repository,
        Logger $logger,
        QualityRepository $qualityRepository
    ) {

        $this->databaseManager     = $databaseManager;
        $this->repository     = $repository;
        $this->logger     = $logger;
        $this->qualityRepository     = $qualityRepository;
    }

    /**
     * Store a newly created resource in storage
     *
     * @param array $data
     *
     * @return TechnicalValues
     *
     * @throws
     */
    public function store(array $data)
    {
        $this->beginTransaction();

        try {
            $technicalData = $this->repository->newInstance();
            $date = array_get($data, 'date');
            $dateModel = Date::firstOrCreate(['date'=> $date], ['date'=> $date]);
            $technicalData->region_id  = array_get($data, 'region_id');
            $technicalData->employee_id = \Auth::user()->employee->id;
            $technicalData->status = 1;
            $technicalData->date_id = $dateModel->id;
            $technicalData->data_type = "A";

            if (!$technicalData->save()) {
                throw new Exception('TechnicalData was not saved to the database.');
            }
            $qualities = array_get($data, 'qualities');

            foreach ($qualities as $key => $value) {
                $value = (float) $value;
                $key = (int) $key;
                $quality = $this->qualityRepository->newInstance();
                $quality->pollutant_id = $key;
                $quality->value = $value;
                $quality->technical_value_id = $technicalData->id;
                $quality->date_id = $technicalData->date_id;

                $pollutant = Pollutant::find($key);
                if (!$pollutant) {
                    throw new Exception('Not pollutant');
                }
                $selectedPollutantValue = null;

                foreach ($pollutant->values as $v) {

                    if ($value < $pollutant->values->min('min') || $value > $pollutant->values->max('max')) {
                        throw new Exception('Your values is incorrect. Min:'. $pollutant->values->min('min') .'Max:' . $pollutant->values->max('max'). 'Input:' . $pollutant->name. ':' . $value);
                    }
                    if ($value >= $v->min && $value <= $v->max) {
                        $selectedPollutantValue = $v;
                    }
                }

                $aqiIndex = null;
                //calculation AQI
                if ($selectedPollutantValue) {
                    $quality->aqi_category_id = $selectedPollutantValue->aqi_category_id;
                    $categoryMax = $selectedPollutantValue->aqiCategory->max;
                    $categoryMin = $selectedPollutantValue->aqiCategory->min;
                    $pollutantMax = $selectedPollutantValue->max;
                    $pollutantMin = $selectedPollutantValue->min;
                    $aqiIndex = ($categoryMax - $categoryMin) / ($pollutantMax - $pollutantMin) * ($value - $pollutantMin) + $categoryMin;
                }
                // end calculation

                $quality->aqi_index = $aqiIndex;

                if (!$quality->save()) {
                    throw new Exception('Quality not saved. ' .$key . ':' . $value);
                }

            }

            $maxAqi = $technicalData->qualities->max('aqi_index');

            $technicalData->value = $maxAqi;

            if (!$technicalData->save()) {
                throw new Exception('TechnicalData was not saved to the database.');
            }
            $this->logger->info('TechnicalData was successfully saved to the database.');

        } catch (Exception $e) {
            $this->rollback($e, $e->getMessage(), [
                'data' => $data,
            ]);
        }

        $this->commit();

        return $technicalData;
    }

}
