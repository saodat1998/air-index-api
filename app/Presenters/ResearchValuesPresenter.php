<?php

namespace App\Presenters;

use App\Transformers\ResearchValuesTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ResearchValuesPresenter.
 *
 * @package namespace App\Presenters;
 */
class ResearchValuesPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ResearchValuesTransformer();
    }
}
