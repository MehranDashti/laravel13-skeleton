<?php

namespace App\Services\Contracts;

/**
 * Interface BaseServiceInterface
 *
 * @package App\Services\Contracts
 */
interface BaseServiceInterface
{
    /**
     * @return int
     */
    public function getServicePaginate(): int;
}
