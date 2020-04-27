<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\LocationCreateRequest;
use App\Http\Requests\LocationUpdateRequest;
use App\Repositories\Contracts\LocationRepository;
use App\Validators\LocationValidator;

/**
 * Class LocationsController.
 *
 * @package namespace App\Http\Controllers\Api\v1;
 */
class LocationsController extends Controller
{
    /**
     * @var LocationRepository
     */
    protected $repository;

    /**
     * @var LocationValidator
     */
    protected $validator;

    /**
     * LocationsController constructor.
     *
     * @param LocationRepository $repository
     * @param LocationValidator $validator
     */
    public function __construct(LocationRepository $repository, LocationValidator $validator)
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
        $locations = $this->repository->all();

        return response()->json([
            'data' => $locations,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param LocationCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(LocationCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $location = $this->repository->create($request->all());

            $response = [
                'message' => 'Location created.',
                'data'    => $location->toArray(),
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
        $location = $this->repository->find($id);

        return response()->json([
            'data' => $location,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param LocationUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(LocationUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $location = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Location updated.',
                'data'    => $location->toArray(),
            ];

            return response()->json($response);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }


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
            'message' => 'Location deleted.',
            'deleted' => $deleted,
        ]);
    }
}
