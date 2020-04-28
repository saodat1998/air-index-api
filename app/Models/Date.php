<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Date.
 *
 * @package namespace App\Models;
 */
class Date extends Model implements Transformable
{
    protected $table = 'time';

    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'id',
		'date',
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function technicalValues()
    {
        return $this->hasMany(TechnicalValues::class, 'date_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function qualities()
    {
        return $this->hasMany(Quality::class, 'date_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function statisticValues()
    {
        return $this->hasMany(StatisticValues::class, 'date_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function researchValues()
    {
        return $this->hasMany(ResearchValues::class, 'date_id', 'id');
    }

}
