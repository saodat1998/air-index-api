<?php

namespace App\Presenters;

use App\Transformers\QualityTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class QualityPresenter.
 *
 * @package namespace App\Presenters;
 */
class QualityPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new QualityTransformer();
    }
}
