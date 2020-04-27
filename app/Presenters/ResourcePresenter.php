<?php

namespace App\Presenters;

use App\Transformers\ResourceTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ResourcePresenter.
 *
 * @package namespace App\Presenters;
 */
class ResourcePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ResourceTransformer();
    }
}
