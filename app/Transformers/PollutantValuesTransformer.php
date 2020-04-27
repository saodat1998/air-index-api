<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\PollutantValues;

/**
 * Class PollutantValuesTransformer.
 *
 * @package namespace App\Transformers;
 */
class PollutantValuesTransformer extends TransformerAbstract
{
    /**
     * Transform the PollutantValues entity.
     *
     * @param \App\Models\PollutantValues $model
     *
     * @return array
     */
    public function transform(PollutantValues $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
