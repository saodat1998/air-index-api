<?php

namespace App\Presenters;

use App\Transformers\UnitTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class UnitPresenter.
 *
 * @package namespace App\Presenters;
 */
class UnitPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new UnitTransformer();
    }
}
