<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\AqiValuesCreateRequest;
use App\Http\Requests\AqiValuesUpdateRequest;
use App\Repositories\Contracts\AqiValuesRepository;
use App\Validators\AqiValuesValidator;

/**
 * Class AqiValuesController.
 *
 * @package namespace App\Http\Controllers\Api\v1;
 */
class AqiValuesController extends Controller
{
    /**
     * @var AqiValuesRepository
     */
    protected $repository;

    /**
     * @var AqiValuesValidator
     */
    protected $validator;

    /**
     * AqiValuesController constructor.
     *
     * @param AqiValuesRepository $repository
     * @param AqiValuesValidator $validator
     */
    public function __construct(AqiValuesRepository $repository, AqiValuesValidator $validator)
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
        $aqiValues = $this->repository->all();

        return response()->json([
            'data' => $aqiValues,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AqiValuesCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AqiValuesCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $aqiValue = $this->repository->create($request->all());

            $response = [
                'message' => 'AqiValues created.',
                'data'    => $aqiValue->toArray(),
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $aqiValue = $this->repository->find($id);

        return response()->json([
            'data' => $aqiValue,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AqiValuesUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(AqiValuesUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $aqiValue = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'AqiValues updated.',
                'data'    => $aqiValue->toArray(),
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
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        return response()->json([
            'message' => 'AqiValues deleted.',
            'deleted' => $deleted,
        ]);
    }
}
