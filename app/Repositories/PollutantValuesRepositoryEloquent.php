<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\PollutantValuesRepository;
use App\Models\PollutantValues;
use App\Validators\PollutantValuesValidator;

/**
 * Class PollutantValuesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PollutantValuesRepositoryEloquent extends BaseRepository implements PollutantValuesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PollutantValues::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return PollutantValuesValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
