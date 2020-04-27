<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\AqiValues;

/**
 * Class AqiValuesTransformer.
 *
 * @package namespace App\Transformers;
 */
class AqiValuesTransformer extends TransformerAbstract
{
    /**
     * Transform the AqiValues entity.
     *
     * @param \App\Models\AqiValues $model
     *
     * @return array
     */
    public function transform(AqiValues $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
