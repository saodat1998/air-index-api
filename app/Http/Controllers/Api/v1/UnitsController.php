<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\UnitCreateRequest;
use App\Http\Requests\UnitUpdateRequest;
use App\Repositories\Contracts\UnitRepository;
use App\Validators\UnitValidator;

/**
 * Class UnitsController.
 *
 * @package namespace App\Http\Controllers\Api\v1;
 */
class UnitsController extends Controller
{
    /**
     * @var UnitRepository
     */
    protected $repository;

    /**
     * @var UnitValidator
     */
    protected $validator;

    /**
     * UnitsController constructor.
     *
     * @param UnitRepository $repository
     * @param UnitValidator $validator
     */
    public function __construct(UnitRepository $repository, UnitValidator $validator)
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
        $units = $this->repository->all();

        return response()->json([
            'data' => $units,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UnitCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UnitCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $unit = $this->repository->create($request->all());

            $response = [
                'message' => 'Unit created.',
                'data'    => $unit->toArray(),
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
        $unit = $this->repository->find($id);

        return response()->json([
            'data' => $unit,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UnitUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UnitUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $unit = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Unit updated.',
                'data'    => $unit->toArray(),
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
            'message' => 'Unit deleted.',
            'deleted' => $deleted,
        ]);
    }
}
