<?php

namespace App\Mediators\Contracts;

use App\Repositories\Contracts\BaseRepositoryInterface;

/**
 * Interface HasRepositoryInterface
 *
 * @package App\Mediators\Contracts
 */
interface HasRepositoryInterface
{
    /**
     * @return BaseRepositoryInterface
     */
    public function repositoryClass(): BaseRepositoryInterface;
}
