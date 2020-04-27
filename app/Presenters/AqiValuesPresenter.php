<?php

namespace App\Presenters;

use App\Transformers\AqiValuesTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class AqiValuesPresenter.
 *
 * @package namespace App\Presenters;
 */
class AqiValuesPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new AqiValuesTransformer();
    }
}
