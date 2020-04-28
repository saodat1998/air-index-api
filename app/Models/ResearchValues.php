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

    protected $appends = ['qualities', 'technical_value', 'date'];

    protected $visible = ['id', 'technical_value', 'date', 'value', 'qualities'];

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
    public function getDateAttribute()
    {
        return $this->dateModel ? $this->dateModel->date : '';
    }

}
