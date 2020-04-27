<?php

namespace App\Http\Controllers\Api\v1;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\DepartmentCreateRequest;
use App\Http\Requests\DepartmentUpdateRequest;
use App\Repositories\Contracts\DepartmentRepository;
use App\Validators\DepartmentValidator;

/**
 * Class DepartmentsController.
 *
 * @package namespace App\Http\Controllers\Api\v1;
 */
class DepartmentsController extends Controller
{
    /**
     * @var DepartmentRepository
     */
    protected $repository;

    /**
     * @var DepartmentValidator
     */
    protected $validator;

    /**
     * DepartmentsController constructor.
     *
     * @param DepartmentRepository $repository
     * @param DepartmentValidator $validator
     */
    public function __construct(DepartmentRepository $repository, DepartmentValidator $validator)
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
        $departments = $this->repository->all();

        return response()->json([
            'data' => $departments,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DepartmentCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(DepartmentCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $department = $this->repository->create($request->all());

            $response = [
                'message' => 'Department created.',
                'data'    => $department->toArray(),
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
        $department = $this->repository->find($id);

        return response()->json([
            'data' => $department,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DepartmentUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(DepartmentUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $department = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Department updated.',
                'data'    => $department->toArray(),
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
            'message' => 'Department deleted.',
            'deleted' => $deleted,
        ]);
    }
}
