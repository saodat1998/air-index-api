<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Unit;

/**
 * Class UnitTransformer.
 *
 * @package namespace App\Transformers;
 */
class UnitTransformer extends TransformerAbstract
{
    /**
     * Transform the Unit entity.
     *
     * @param \App\Models\Unit $model
     *
     * @return array
     */
    public function transform(Unit $model)
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
