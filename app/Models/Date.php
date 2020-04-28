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

    protected $appends = ['statistic', 'research', 'technical'];

    protected $visible = ['date', 'statistic', 'research', 'technical'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'id',
		'date',
	];

    protected $hidden = ['id', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function technicalValue()
    {
        return $this->hasOne(TechnicalValues::class, 'date_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function qualities()
    {
        return $this->hasMany(Quality::class, 'date_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function statisticValue()
    {
        return $this->hasOne(StatisticValues::class, 'date_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function researchValue()
    {
        return $this->hasOne(ResearchValues::class, 'date_id', 'id');
    }

    public function getTechnicalAttribute()
    {
        return $this->technicalValue && $this->technicalValue->value ? $this->technicalValue->value : "";
    }

    public function getResearchAttribute()
    {
        return $this->researchValue && $this->researchValue->value ? $this->researchValue->value : "";
    }

    public function getStatisticAttribute()
    {
        return $this->statisticValue && $this->statisticValue->value ? $this->statisticValue->value : "";
    }

}
