<?php

namespace App\Presenters;

use App\Transformers\PollutantValuesTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class PollutantValuesPresenter.
 *
 * @package namespace App\Presenters;
 */
class PollutantValuesPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new PollutantValuesTransformer();
    }
}
