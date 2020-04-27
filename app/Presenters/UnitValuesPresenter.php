<?php

namespace App\Presenters;

use App\Transformers\UnitValuesTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class UnitValuesPresenter.
 *
 * @package namespace App\Presenters;
 */
class UnitValuesPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new UnitValuesTransformer();
    }
}
