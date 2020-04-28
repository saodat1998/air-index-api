<?php

namespace App\Presenters;

use App\Transformers\DateTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class DatePresenter.
 *
 * @package namespace App\Presenters;
 */
class DatePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new DateTransformer();
    }
}
