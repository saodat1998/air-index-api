<?php

namespace App\Presenters;

use App\Transformers\StatisticValuesTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class StatisticValuesPresenter.
 *
 * @package namespace App\Presenters;
 */
class StatisticValuesPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new StatisticValuesTransformer();
    }
}
