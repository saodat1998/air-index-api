<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Quality;

/**
 * Class QualityTransformer.
 *
 * @package namespace App\Transformers;
 */
class QualityTransformer extends TransformerAbstract
{
    /**
     * Transform the Quality entity.
     *
     * @param \App\Models\Quality $model
     *
     * @return array
     */
    public function transform(Quality $model)
    {
        return [
            'id'                 => (int) $model->id,
            'pollutant_id'       => (int) $model->pollutant_id,
            'technical_value_id' => (int) $model->technical_value_id,
            'value'              => (float) $model->value,
            'created_at'         => $model->created_at,
            'updated_at'         => $model->updated_at
        ];
    }
}
