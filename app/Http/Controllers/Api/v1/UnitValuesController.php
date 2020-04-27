<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\UnitValuesCreateRequest;
use App\Http\Requests\UnitValuesUpdateRequest;
use App\Repositories\Contracts\UnitValuesRepository;
use App\Validators\UnitValuesValidator;

/**
 * Class UnitValuesController.
 *
 * @package namespace App\Http\Controllers\Api\v1;
 */
class UnitValuesController extends Controller
{
    /**
     * @var UnitValuesRepository
     */
    protected $repository;

    /**
     * @var UnitValuesValidator
     */
    protected $validator;

    /**
     * UnitValuesController constructor.
     *
     * @param UnitValuesRepository $repository
     * @param UnitValuesValidator $validator
     */
    public function __construct(UnitValuesRepository $repository, UnitValuesValidator $validator)
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
        $unitValues = $this->repository->all();

        return response()->json([
            'data' => $unitValues,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UnitValuesCreateRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(UnitValuesCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $unitValue = $this->repository->create($request->all());

            $response = [
                'message' => 'UnitValues created.',
                'data'    => $unitValue->toArray(),
            ];

            return response()->json($response);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
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
        $unitValue = $this->repository->find($id);

        return response()->json([
            'data' => $unitValue,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UnitValuesUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UnitValuesUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $unitValue = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'UnitValues updated.',
                'data'    => $unitValue->toArray(),
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
            'message' => 'UnitValues deleted.',
            'deleted' => $deleted,
        ]);
    }
}
