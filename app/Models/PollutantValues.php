<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class PollutantValues.
 *
 * @package namespace App\Models;
 */
class PollutantValues extends Model implements Transformable
{
    use TransformableTrait;

    protected $appends = ['aqi_category_name'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'id',
		'pollutant_id',
		'aqi_category_id',
		'min',
		'max',
	];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pollutant()
    {
        return $this->belongsTo(Pollutant::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function aqiCategory()
    {
        return $this->belongsTo(AqiCategory::class);
    }

    /**
     * @return string
     */
    public function getAqiCategoryNameAttribute()
    {
        return $this->aqiCategory ? $this->aqiCategory->name : '';
    }
}
