<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\PresentableTrait;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Region.
 *
 * @package namespace App\Models;
 */
class Region extends Model implements Transformable
{
    use TransformableTrait, PresentableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'id',
		'name',
		'hasc',
		'iso',
		'area_km',
		'area_mi',
		'capital',
		'zip_code',
		'population',
		'vehicles',
		'location_id',
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function technicalValues()
    {
        return $this->hasMany(TechnicalValues::class, 'region_id', 'id');
    }

}
