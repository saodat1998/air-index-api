<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\PresentableTrait;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class ResearchValues.
 *
 * @package namespace App\Models;
 */
class ResearchValues extends Model implements Transformable
{
    protected $table = 'researcher';

    use TransformableTrait, PresentableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'technical_value_id',
        'value',
        'employee_id',
        'status',
        'date',
	];

}
