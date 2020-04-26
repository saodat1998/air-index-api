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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $units = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $units,
            ]);
        }

        return view('units.index', compact('units'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UnitCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
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

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
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
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $unit = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $unit,
            ]);
        }

        return view('units.show', compact('unit'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $unit = $this->repository->find($id);

        return view('units.edit', compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UnitUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
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

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
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
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Unit deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Unit deleted.');
    }
}
