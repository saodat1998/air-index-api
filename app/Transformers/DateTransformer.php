<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Date;

/**
 * Class DateTransformer.
 *
 * @package namespace App\Transformers;
 */
class DateTransformer extends TransformerAbstract
{
    /**
     * Transform the Date entity.
     *
     * @param \App\Models\Date $model
     *
     * @return array
     */
    public function transform(Date $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
