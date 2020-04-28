<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\EmployeeCreateRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Repositories\Contracts\EmployeeRepository;
use App\Validators\EmployeeValidator;

/**
 * Class EmployeesController.
 *
 * @package namespace App\Http\Controllers\Api\v1;
 */
class EmployeesController extends Controller
{
    /**
     * @var EmployeeRepository
     */
    protected $repository;

    /**
     * @var EmployeeValidator
     */
    protected $validator;

    /**
     * EmployeesController constructor.
     *
     * @param EmployeeRepository $repository
     * @param EmployeeValidator $validator
     */
    public function __construct(EmployeeRepository $repository, EmployeeValidator $validator)
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
        $employees = $this->repository->with(['user', 'department'])->all();

        return response()->json([
            'data' => $employees,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EmployeeCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(EmployeeCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $employee = $this->repository->create($request->all());

            $response = [
                'message' => 'Employee created.',
                'data'    => $employee->toArray(),
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
        $employee = $this->repository->with(['user', 'department'])->find($id);

        return response()->json([
            'data' => $employee,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EmployeeUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(EmployeeUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $employee = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Employee updated.',
                'data'    => $employee->toArray(),
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
            'message' => 'Employee deleted.',
            'deleted' => $deleted,
        ]);
    }
}
