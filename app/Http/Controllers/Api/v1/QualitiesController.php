<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\QualityCreateRequest;
use App\Http\Requests\QualityUpdateRequest;
use App\Repositories\Contracts\QualityRepository;
use App\Validators\QualityValidator;

/**
 * Class QualitiesController.
 *
 * @package namespace App\Http\Controllers\Api\v1;
 */
class QualitiesController extends Controller
{
    /**
     * @var QualityRepository
     */
    protected $repository;

    /**
     * @var QualityValidator
     */
    protected $validator;

    /**
     * QualitiesController constructor.
     *
     * @param QualityRepository $repository
     * @param QualityValidator $validator
     */
    public function __construct(QualityRepository $repository, QualityValidator $validator)
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
        $qualities = $this->repository->all();

        return response()->json([
            'data' => $qualities,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param QualityCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(QualityCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $quality = $this->repository->create($request->all());

            $response = [
                'message' => 'Quality created.',
                'data'    => $quality->toArray(),
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
        $quality = $this->repository->find($id);
        return response()->json([
            'data' => $quality,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param QualityUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(QualityUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $quality = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Quality updated.',
                'data'    => $quality->toArray(),
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
            'message' => 'Quality deleted.',
            'deleted' => $deleted,
        ]);
    }
}
