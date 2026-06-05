<?php

namespace App\Services\Contracts;

/**
 * Interface ClientConditionInterface
 *
 * @package App\Services\Contracts
 */
interface ClientConditionInterface
{
    /**
     * @return self
     */
    public function considerClientCondition(): self;
}
