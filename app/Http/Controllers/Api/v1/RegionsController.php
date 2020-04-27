<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\RegionCreateRequest;
use App\Http\Requests\RegionUpdateRequest;
use App\Repositories\Contracts\RegionRepository;
use App\Validators\RegionValidator;

/**
 * Class RegionsController.
 *
 * @package namespace App\Http\Controllers\Api\v1;
 */
class RegionsController extends Controller
{
    /**
     * @var RegionRepository
     */
    protected $repository;

    /**
     * @var RegionValidator
     */
    protected $validator;

    /**
     * RegionsController constructor.
     *
     * @param RegionRepository $repository
     * @param RegionValidator $validator
     */
    public function __construct(RegionRepository $repository, RegionValidator $validator)
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
        $regions = $this->repository->all();

        return response()->json([
            'data' => $regions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RegionCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RegionCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $region = $this->repository->create($request->all());

            $response = [
                'message' => 'Region created.',
                'data'    => $region->toArray(),
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
        $region = $this->repository->find($id);

        return response()->json([
            'data' => $region,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RegionUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(RegionUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $region = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Region updated.',
                'data'    => $region->toArray(),
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
            'message' => 'Region deleted.',
            'deleted' => $deleted,
        ]);
    }
}
