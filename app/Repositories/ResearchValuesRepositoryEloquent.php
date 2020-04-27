<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\ResearchValuesRepository;
use App\Models\ResearchValues;
use App\Validators\ResearchValuesValidator;

/**
 * Class ResearchValuesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ResearchValuesRepositoryEloquent extends BaseRepository implements ResearchValuesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ResearchValues::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return ResearchValuesValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
