<?php

namespace App\Mediators;

use App\Mediators\Contracts\BaseMediator;
use App\Mediators\Contracts\HasRepositoryInterface;
use App\Repositories\Contracts\BaseRepositoryInterface;
use App\Repositories\Contracts\SampleRepositoryInterface;

/**
 * Class UserMediator
 *
 * @package App\Mediators
 */
class SampleMediator extends BaseMediator implements HasRepositoryInterface
{
    /**
     * @return BaseRepositoryInterface
     */
    public function repositoryClass(): BaseRepositoryInterface
    {
        return app(SampleRepositoryInterface::class);
    }
}
