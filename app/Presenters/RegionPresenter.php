<?php

namespace App\Presenters;

use App\Transformers\RegionTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class RegionPresenter.
 *
 * @package namespace App\Presenters;
 */
class RegionPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new RegionTransformer();
    }
}
