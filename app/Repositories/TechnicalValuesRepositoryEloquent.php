<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\TechnicalValuesRepository;
use App\Models\TechnicalValues;
use App\Validators\TechnicalValuesValidator;

/**
 * Class TechnicalValuesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TechnicalValuesRepositoryEloquent extends BaseRepository implements TechnicalValuesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TechnicalValues::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return TechnicalValuesValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
