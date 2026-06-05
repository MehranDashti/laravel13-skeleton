<?php

namespace App\Mediators\Contracts;

use App\Services\Contracts\BaseServiceInterface;
use App\Repositories\Contracts\BaseRepositoryInterface;

/**
 * Interface BaseMediatorInterface
 *
 * @package App\Mediators\Contracts
 */
interface BaseMediatorInterface
{
    public function setService(BaseServiceInterface $service): static;

    public function getService(): BaseServiceInterface;

    public function setRepository(BaseRepositoryInterface $repository): static;

    public function getRepository(): BaseRepositoryInterface;
}
