<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\PollutantRepository;
use App\Models\Pollutant;
use App\Validators\PollutantValidator;

/**
 * Class PollutantRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PollutantRepositoryEloquent extends BaseRepository implements PollutantRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Pollutant::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return PollutantValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
