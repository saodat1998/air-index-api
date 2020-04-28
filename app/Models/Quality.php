<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Quality.
 *
 * @package namespace App\Models;
 */
class Quality extends Model implements Transformable
{
    use TransformableTrait;

    protected $appends = ['pollutant_name'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pollutant_id',
        'technical_value_id',
        'value',
        'date',
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pollutant()
    {
        return $this->belongsTo(Pollutant::class);
    }

    /**
     * @return string
     */
    public function getPollutantNameAttribute()
    {
        return $this->pollutant ? $this->pollutant->name : "";
    }

}
