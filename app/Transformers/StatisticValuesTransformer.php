<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\StatisticValues;

/**
 * Class StatisticValuesTransformer.
 *
 * @package namespace App\Transformers;
 */
class StatisticValuesTransformer extends TransformerAbstract
{
    /**
     * Transform the StatisticValues entity.
     *
     * @param \App\Models\StatisticValues $model
     *
     * @return array
     */
    public function transform(StatisticValues $model)
    {
        return [
            'id'          => (int) $model->id,
            'value'       => (float) $model->value,
            'employee_id' => (float) $model->employee_id,
            'status'      => (float) $model->status,
            'created_at'  => $model->created_at,
            'updated_at'  => $model->updated_at
        ];
    }
}
