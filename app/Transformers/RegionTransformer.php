<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Region;

/**
 * Class RegionTransformer.
 *
 * @package namespace App\Transformers;
 */
class RegionTransformer extends TransformerAbstract
{
    /**
     * Transform the Region entity.
     *
     * @param \App\Models\Region $model
     *
     * @return array
     */
    public function transform(Region $model)
    {
        return [
            'id'         => (int) $model->id,
            'name'         => (string) $model->name,
            'zip_code'         => (string) $model->zip_code,
            'population'         => (int) $model->population,
            'vehicles'         => (int) $model->vehicles,
            'location_id'         => (int) $model->location_id,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
