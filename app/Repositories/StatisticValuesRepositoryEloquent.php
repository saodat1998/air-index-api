<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\StatisticValuesRepository;
use App\Models\StatisticValues;
use App\Validators\StatisticValuesValidator;

/**
 * Class StatisticValuesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class StatisticValuesRepositoryEloquent extends BaseRepository implements StatisticValuesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return StatisticValues::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return StatisticValuesValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
