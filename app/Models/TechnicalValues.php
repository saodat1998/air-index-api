<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\PresentableTrait;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class TechnicalValues.
 *
 * @package namespace App\Models;
 */
class TechnicalValues extends Model implements Transformable
{
    use TransformableTrait, PresentableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'value',
		'employee_id',
		'region_id',
		'aqi_category_id',
		'status',
	];

}
