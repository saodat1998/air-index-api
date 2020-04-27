<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\ResearchValues;

/**
 * Class ResearchValuesTransformer.
 *
 * @package namespace App\Transformers;
 */
class ResearchValuesTransformer extends TransformerAbstract
{
    /**
     * Transform the ResearchValues entity.
     *
     * @param \App\Models\ResearchValues $model
     *
     * @return array
     */
    public function transform(ResearchValues $model)
    {
        return [
            'id'                 => (int) $model->id,
            'technical_value_id' => (int) $model->technical_value_id,
            'employee_id'        => (int) $model->employee_id,
            'status'             => (int) $model->status,
            'value'              => (float) $model->value,
            'created_at'         => $model->created_at,
            'updated_at'         => $model->updated_at
        ];
    }
}
