<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\AqiCategory;

/**
 * Class AqiCategoryTransformer.
 *
 * @package namespace App\Transformers;
 */
class AqiCategoryTransformer extends TransformerAbstract
{
    /**
     * Transform the AqiCategory entity.
     *
     * @param \App\Models\AqiCategory $model
     *
     * @return array
     */
    public function transform(AqiCategory $model)
    {
        return [
            'id'          => (int) $model->id,
            'name'        => (string) $model->name,
            'max'         => (float) $model->max,
            'min'         => (float) $model->min,
            'avg'         => (float) $model->avg,
            'unit_id'     => (int) $model->unit_id,
            'description' => (string) $model->description,
            'created_at'  => $model->created_at,
            'updated_at'  => $model->updated_at
        ];
    }
}
