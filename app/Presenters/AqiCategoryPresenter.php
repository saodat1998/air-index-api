<?php

namespace App\Presenters;

use App\Transformers\AqiCategoryTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class AqiCategoryPresenter.
 *
 * @package namespace App\Presenters;
 */
class AqiCategoryPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new AqiCategoryTransformer();
    }
}
