<?php

namespace App\Http\Controllers\Api\v1;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\DateCreateRequest;
use App\Http\Requests\DateUpdateRequest;
use App\Repositories\Contracts\DateRepository;
use App\Validators\DateValidator;

/**
 * Class DatesController.
 *
 * @package namespace App\Http\Controllers\Api\v1;
 */
class DatesController extends Controller
{
    /**
     * @var DateRepository
     */
    protected $repository;

    /**
     * @var DateValidator
     */
    protected $validator;

    /**
     * DatesController constructor.
     *
     * @param DateRepository $repository
     * @param DateValidator $validator
     */
    public function __construct(DateRepository $repository, DateValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     *  Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $input = $request->all();
        $now = Carbon::now('UTC')->format('Y-m-d');

        $defaultStart = Carbon::createFromFormat('Y-m-d', substr($now, 0, 10))->subDays(30)->toDateString();

        $from = array_get($input, 'date_from', $defaultStart);
        $to = array_get($input, 'date_from', $now);

        $dates = $this->repository
            ->with(['technicalValues', 'qualities', 'statisticValues', 'researchValues'])
            ->whereBetween('date', [$from, $to])
            ->get();

        return response()->json([
            'data' => $dates->toArray(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param $date
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($date)
    {
        $date = $this->repository
            ->with(['technicalValues', 'qualities', 'statisticValues', 'researchValues'])
            ->whereDate('date', $date)
            ->first();

        return response()->json([
            'data' => $date,
        ]);
    }
}
