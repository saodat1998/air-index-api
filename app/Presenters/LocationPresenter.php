<?php

namespace App\Presenters;

use App\Transformers\LocationTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class LocationPresenter.
 *
 * @package namespace App\Presenters;
 */
class LocationPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new LocationTransformer();
    }
}
