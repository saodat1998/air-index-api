<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\UnitValues;

/**
 * Class UnitValuesTransformer.
 *
 * @package namespace App\Transformers;
 */
class UnitValuesTransformer extends TransformerAbstract
{
    /**
     * Transform the UnitValues entity.
     *
     * @param \App\Models\UnitValues $model
     *
     * @return array
     */
    public function transform(UnitValues $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
