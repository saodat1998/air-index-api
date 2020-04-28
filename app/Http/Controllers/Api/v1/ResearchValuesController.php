<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\TechnicalValues;
use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ResearchValuesCreateRequest;
use App\Http\Requests\ResearchValuesUpdateRequest;
use App\Repositories\Contracts\ResearchValuesRepository;
use App\Validators\ResearchValuesValidator;

/**
 * Class ResearchValuesController.
 *
 * @package namespace App\Http\Controllers\Api\v1;
 */
class ResearchValuesController extends Controller
{
    /**
     * @var ResearchValuesRepository
     */
    protected $repository;

    /**
     * @var ResearchValuesValidator
     */
    protected $validator;

    /**
     * ResearchValuesController constructor.
     *
     * @param ResearchValuesRepository $repository
     * @param ResearchValuesValidator $validator
     */
    public function __construct(ResearchValuesRepository $repository, ResearchValuesValidator $validator)
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
        $researchValues = $this->repository->all();

        return response()->json([
            'data' => $researchValues,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ResearchValuesCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ResearchValuesCreateRequest $request)
    {
        try {

            $input = $request->all();

            $this->validator->with($input)->passesOrFail(ValidatorInterface::RULE_CREATE);

            $technicalValue = TechnicalValues::findOrFail(array_get($input, 'technical_value_id'));
            $technicalValue->status = 2;
            $researchValue = $this->repository->create([
                'technical_value_id' => $technicalValue->id,
                'value' => array_get($input, 'value', $technicalValue->value),
                'status' => 1,
                'employee_id' => \Auth::user()->employee->id,
            ]);
            $technicalValue->save();

            $response = [
                'message' => 'ResearchValues created.',
                'data'    => $researchValue->toArray(),
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
        $researchValue = $this->repository->find($id);

        return response()->json([
            'data' => $researchValue,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ResearchValuesUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ResearchValuesUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $researchValue = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'ResearchValues updated.',
                'data'    => $researchValue->toArray(),
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
            'message' => 'ResearchValues deleted.',
            'deleted' => $deleted,
        ]);
    }
}
