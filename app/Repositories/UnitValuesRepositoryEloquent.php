<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\UnitValuesRepository;
use App\Models\UnitValues;
use App\Validators\UnitValuesValidator;

/**
 * Class UnitValuesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class UnitValuesRepositoryEloquent extends BaseRepository implements UnitValuesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return UnitValues::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return UnitValuesValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
