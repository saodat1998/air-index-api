<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ResourceCreateRequest;
use App\Http\Requests\ResourceUpdateRequest;
use App\Repositories\Contracts\ResourceRepository;
use App\Validators\ResourceValidator;

/**
 * Class ResourcesController.
 *
 * @package namespace App\Http\Controllers\Api\v1;
 */
class ResourcesController extends Controller
{
    /**
     * @var ResourceRepository
     */
    protected $repository;

    /**
     * @var ResourceValidator
     */
    protected $validator;

    /**
     * ResourcesController constructor.
     *
     * @param ResourceRepository $repository
     * @param ResourceValidator $validator
     */
    public function __construct(ResourceRepository $repository, ResourceValidator $validator)
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
        $resources = $this->repository->all();

        return response()->json([
            'data' => $resources,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ResourceCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ResourceCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $resource = $this->repository->create($request->all());

            $response = [
                'message' => 'Resource created.',
                'data'    => $resource->toArray(),
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
        $resource = $this->repository->find($id);

        return response()->json([
            'data' => $resource,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ResourceUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ResourceUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $resource = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Resource updated.',
                'data'    => $resource->toArray(),
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
            'message' => 'Resource deleted.',
            'deleted' => $deleted,
        ]);
    }
}
