<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\AqiCategoryCreateRequest;
use App\Http\Requests\AqiCategoryUpdateRequest;
use App\Repositories\Contracts\AqiCategoryRepository;
use App\Validators\AqiCategoryValidator;

/**
 * Class AqiCategoriesController.
 *
 * @package namespace App\Http\Controllers\Api\v1;
 */
class AqiCategoriesController extends Controller
{
    /**
     * @var AqiCategoryRepository
     */
    protected $repository;

    /**
     * @var AqiCategoryValidator
     */
    protected $validator;

    /**
     * AqiCategoriesController constructor.
     *
     * @param AqiCategoryRepository $repository
     * @param AqiCategoryValidator $validator
     */
    public function __construct(AqiCategoryRepository $repository, AqiCategoryValidator $validator)
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
        $aqiCategories = $this->repository->all();

        return response()->json([
            'data' => $aqiCategories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AqiCategoryCreateRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(AqiCategoryCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $aqiCategory = $this->repository->create($request->all());

            $response = [
                'message' => 'AqiCategory created.',
                'data'    => $aqiCategory->toArray(),
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
        $aqiCategory = $this->repository->find($id);

        return response()->json([
            'data' => $aqiCategory,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AqiCategoryUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(AqiCategoryUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $aqiCategory = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'AqiCategory updated.',
                'data'    => $aqiCategory->toArray(),
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
            'message' => 'AqiCategory deleted.',
            'deleted' => $deleted,
        ]);
    }
}
