<?php

namespace App\Presenters;

use App\Transformers\TechnicalValuesTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class TechnicalValuesPresenter.
 *
 * @package namespace App\Presenters;
 */
class TechnicalValuesPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new TechnicalValuesTransformer();
    }
}
