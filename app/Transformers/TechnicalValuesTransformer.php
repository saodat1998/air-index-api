<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\TechnicalValues;

/**
 * Class TechnicalValuesTransformer.
 *
 * @package namespace App\Transformers;
 */
class TechnicalValuesTransformer extends TransformerAbstract
{
    /**
     * Transform the TechnicalValues entity.
     *
     * @param \App\Models\TechnicalValues $model
     *
     * @return array
     */
    public function transform(TechnicalValues $model)
    {
        return [
            'id'          => (int) $model->id,
            'value'       => (float) $model->value,
            'region_id'   => (int) $model->region_id,
            'employee_id' => (int) $model->employee_id,
            'status'      => (int) $model->status,
            'created_at'  => $model->created_at,
            'updated_at'  => $model->updated_at
        ];
    }
}
