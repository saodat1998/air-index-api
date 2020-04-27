<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\AqiCategoryRepository;
use App\Models\AqiCategory;
use App\Validators\AqiCategoryValidator;

/**
 * Class AqiCategoryRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class AqiCategoryRepositoryEloquent extends BaseRepository implements AqiCategoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AqiCategory::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return AqiCategoryValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
