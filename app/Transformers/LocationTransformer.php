<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Location;

/**
 * Class LocationTransformer.
 *
 * @package namespace App\Transformers;
 */
class LocationTransformer extends TransformerAbstract
{
    /**
     * Transform the Location entity.
     *
     * @param \App\Models\Location $model
     *
     * @return array
     */
    public function transform(Location $model)
    {
        return [
            'id'         => (int) $model->id,
            'longitude'         => (string) $model->longitude,
            'latitude'         => (string) $model->latitude,
            'geojson'         => (string) $model->geojson,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
