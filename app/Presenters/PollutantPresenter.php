<?php

namespace App\Presenters;

use App\Transformers\PollutantTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class PollutantPresenter.
 *
 * @package namespace App\Presenters;
 */
class PollutantPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new PollutantTransformer();
    }
}
