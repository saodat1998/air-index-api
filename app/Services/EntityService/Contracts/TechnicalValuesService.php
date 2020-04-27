<?php

namespace App\Services\EntityService\Contracts;

use App\Models\TechnicalValues;

/**
 * Interface TechnicalValuesService
 *
 * @package App\Services\EntityService\Contracts
 */
interface TechnicalValuesService extends BaseService
{
    /**
     * Store a newly created resource in storage
     *
     * @param array $data
     * @return TechnicalValues
     */
    public function store(array $data);
}
