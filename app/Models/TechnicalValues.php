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
    protected $table = 'technician';

    use TransformableTrait, PresentableTrait;

    protected $appends = ['aqi_category_name', 'region_name', 'researcher_value'];

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
		'date_id',
		'data_type',
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function researcherValueModel()
    {
        return $this->hasOne(ResearchValues::class, 'technical_value_id', 'id');
    }

    public function getResearcherValueAttribute()
    {
        return $this->researcherValueModel && $this->researcherValueModel->value ? $this->researcherValueModel->value : '';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function qualities()
    {
        return $this->hasMany(Quality::class, 'technical_value_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function aqiCategory()
    {
        return $this->belongsTo(AqiCategory::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function date()
    {
        return $this->belongsTo(Date::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * @return string
     */
    public function getAqiCategoryNameAttribute()
    {
        return $this->aqiCategory ? $this->aqiCategory->name : '';
    }

    /**
     * @return string
     */
    public function getRegionNameAttribute()
    {
        return $this->region ? $this->region->name : '';
    }

    /**
     * @return string
     */
    public function getEmployeeNameAttribute()
    {
        return $this->employee ? $this->employee->user->first_name : '';
    }
}
