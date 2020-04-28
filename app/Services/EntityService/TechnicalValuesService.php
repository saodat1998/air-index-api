<?php

namespace App\Services\EntityService;

use App\Models\Date;
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
                $qualityRepository = $this->qualityRepository->newInstance();
                $qualityRepository->pollutant_id = $key;
                $qualityRepository->value = $value;
                $qualityRepository->technical_value_id = $technicalData->id;
                $qualityRepository->date = $technicalData->date;

                if (!$qualityRepository->save()) {
                    throw new Exception('Quality not saved. ' .$key . ':' . $value);
                }
            }

            if (!$technicalData->save()) {
                throw new Exception('TechnicalData was not saved to the database.');
            }
            $this->logger->info('TechnicalData was successfully saved to the database.');

        } catch (Exception $e) {
            $this->rollback($e, 'An error occurred while storing an ', [
                'data' => $data,
            ]);
        }

        $this->commit();

        return $technicalData;
    }

}
