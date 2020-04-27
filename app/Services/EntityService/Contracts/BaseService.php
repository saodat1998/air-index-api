<?php

namespace App\Services\EntityService\Contracts;

interface BaseService
{
    /**
     * Get last error message.
     *
     * @return string
     */
    public function getError();

    /**
     * Get message.
     *
     * @return string
     */
    public function getMessage();
}
