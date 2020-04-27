<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\StatisticValuesCreateRequest;
use App\Http\Requests\StatisticValuesUpdateRequest;
use App\Repositories\Contracts\StatisticValuesRepository;
use App\Validators\StatisticValuesValidator;

/**
 * Class StatisticValuesController.
 *
 * @package namespace App\Http\Controllers\Api\v1;
 */
class StatisticValuesController extends Controller
{
    /**
     * @var StatisticValuesRepository
     */
    protected $repository;

    /**
     * @var StatisticValuesValidator
     */
    protected $validator;

    /**
     * StatisticValuesController constructor.
     *
     * @param StatisticValuesRepository $repository
     * @param StatisticValuesValidator $validator
     */
    public function __construct(StatisticValuesRepository $repository, StatisticValuesValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $statisticValues = $this->repository->all();

        return response()->json([
            'data' => $statisticValues,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StatisticValuesCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StatisticValuesCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $statisticValue = $this->repository->create($request->all());

            $response = [
                'message' => 'StatisticValues created.',
                'data'    => $statisticValue->toArray(),
            ];

            return response()->json($response);
        } catch (ValidatorException $e) {
            return response()->json([
                'error'   => true,
                'message' => $e->getMessageBag()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $statisticValue = $this->repository->find($id);

        return response()->json([
            'data' => $statisticValue,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StatisticValuesUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(StatisticValuesUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $statisticValue = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'StatisticValues updated.',
                'data'    => $statisticValue->toArray(),
            ];

            return response()->json($response);
        } catch (ValidatorException $e) {

            return response()->json([
                'error'   => true,
                'message' => $e->getMessageBag()
            ]);

        }
    }


    /**
     *  Remove the specified resource from storage.
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        return response()->json([
            'message' => 'StatisticValues deleted.',
            'deleted' => $deleted,
        ]);
    }
}
