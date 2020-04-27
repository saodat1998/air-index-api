<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\PollutantCreateRequest;
use App\Http\Requests\PollutantUpdateRequest;
use App\Repositories\Contracts\PollutantRepository;
use App\Validators\PollutantValidator;

/**
 * Class PollutantsController.
 *
 * @package namespace App\Http\Controllers\Api\v1;
 */
class PollutantsController extends Controller
{
    /**
     * @var PollutantRepository
     */
    protected $repository;

    /**
     * @var PollutantValidator
     */
    protected $validator;

    /**
     * PollutantsController constructor.
     *
     * @param PollutantRepository $repository
     * @param PollutantValidator $validator
     */
    public function __construct(PollutantRepository $repository, PollutantValidator $validator)
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
     * @param PollutantCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PollutantCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $unit = $this->repository->create($request->all());

            $response = [
                'message' => 'Pollutant created.',
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
     * @param PollutantUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PollutantUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $unit = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Pollutant updated.',
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
            'message' => 'Pollutant deleted.',
            'deleted' => $deleted,
        ]);
    }
}
