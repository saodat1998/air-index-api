<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\TechnicalValuesCreateRequest;
use App\Http\Requests\TechnicalValuesUpdateRequest;
use App\Repositories\Contracts\TechnicalValuesRepository;
use App\Validators\TechnicalValuesValidator;

/**
 * Class TechnicalValuesController.
 *
 * @package namespace App\Http\Controllers\Api\v1;
 */
class TechnicalValuesController extends Controller
{
    /**
     * @var TechnicalValuesRepository
     */
    protected $repository;

    /**
     * @var TechnicalValuesValidator
     */
    protected $validator;

    /**
     * TechnicalValuesController constructor.
     *
     * @param TechnicalValuesRepository $repository
     * @param TechnicalValuesValidator $validator
     */
    public function __construct(TechnicalValuesRepository $repository, TechnicalValuesValidator $validator)
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
        $technicValues = $this->repository->with(['aqi_values'])->all();

        return response()->json([
            'data' => $technicValues,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TechnicalValuesCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TechnicalValuesCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $technicValue = $this->repository->create($request->all());

            $response = [
                'message' => 'TechnicalValues created.',
                'data'    => $technicValue->toArray(),
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
        $technicValue = $this->repository->with(['aqi_values'])->find($id);

        return response()->json([
            'data' => $technicValue,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TechnicalValuesUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TechnicalValuesUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $technicValue = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'TechnicalValues updated.',
                'data'    => $technicValue->toArray(),
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
            'message' => 'TechnicalValues deleted.',
            'deleted' => $deleted,
        ]);
    }
}
