<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\AqiValuesRepository;
use App\Models\AqiValues;
use App\Validators\AqiValuesValidator;

/**
 * Class AqiValuesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class AqiValuesRepositoryEloquent extends BaseRepository implements AqiValuesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AqiValues::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return AqiValuesValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
