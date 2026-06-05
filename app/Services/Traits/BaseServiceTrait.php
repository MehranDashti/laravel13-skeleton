<?php

namespace App\Services\Traits;

use App\Mediators\Contracts\BaseMediatorInterface;

/**
 * Trait BaseServiceTrait
 *
 * @package App\Services\Contracts
 */
trait BaseServiceTrait
{
    /** @var BaseMediatorInterface $mediator */
    protected BaseMediatorInterface $mediator;

    /** @var bool $ignoreMediator */
    protected bool $ignoreMediator = false;

    /**
     * @param bool $ignoreMediator
     *
     * @return $this
     */
    public function setIgnoreMediator(bool $ignoreMediator): self
    {
        $this->ignoreMediator = $ignoreMediator;

        return $this;
    }

    /**
     * @return bool
     */
    public function getIgnoreMediator(): bool
    {
        return $this->ignoreMediator;
    }

    /**
     * @return int
     */
    public function getServicePaginate(): int
    {
        return 15;
    }
}
