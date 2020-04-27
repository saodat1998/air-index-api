<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Pollutant;

/**
 * Class PollutantTransformer.
 *
 * @package namespace App\Transformers;
 */
class PollutantTransformer extends TransformerAbstract
{
    /**
     * Transform the Pollutant entity.
     *
     * @param \App\Models\Pollutant $model
     *
     * @return array
     */
    public function transform(Pollutant $model)
    {
        return [
            'id'         => (int) $model->id,
            'name'         => (string) $model->name,
            'formula'         => (string) $model->formula,
            'note'         => (string) $model->note,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
