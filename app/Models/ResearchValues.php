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

    protected $appends = ['qualities', 'technical_value', 'date', 'region_name', 'statistic_value'];

    protected $visible = ['id', 'technical_value', 'date', 'value', 'qualities', 'status', 'region_name', 'statistic_value'];

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
        'date_id',
	];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function statisticValueModel()
    {
        return $this->hasOne(StatisticValues::class, 'research_value_id', 'id');
    }

    public function getStatisticValueAttribute()
    {
        return $this->statisticValueModel && $this->statisticValueModel->value ? $this->statisticValueModel->value : '';
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function technicalModel()
    {
        return $this->hasOne(TechnicalValues::class, 'id', 'technical_value_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function dateModel()
    {
        return $this->hasOne(Date::class, 'id', 'date_id');
    }

    /**
     * @return mixed
     */
    public function getQualitiesAttribute()
    {
        return $this->technicalModel && $this->technicalModel->qualities ? $this->technicalModel->qualities : '';
    }

    /**
     * @return mixed
     */
    public function getTechnicalValueAttribute()
    {
        return $this->technicalModel && $this->technicalModel->value ? $this->technicalModel->value : '';
    }

    /**
     * @return mixed
     */
    public function getRegionNameAttribute()
    {
        return $this->technicalModel && $this->technicalModel->region_name ? $this->technicalModel->region_name : '';
    }

    /**
     * @return mixed
     */
    public function getDateAttribute()
    {
        return $this->dateModel ? $this->dateModel->date : '';
    }

}
