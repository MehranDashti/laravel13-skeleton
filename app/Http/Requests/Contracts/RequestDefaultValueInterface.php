<?php

namespace App\Http\Requests\Contracts;

/**
 * Interface RequestDefaultValueInterface
 *
 * @package App\Http\Requests\Contracts
 */
interface RequestDefaultValueInterface
{
    /**
     * @return array
     */
    public function defaultValues(): array;

    /**
     * @return bool
     */
    public function prepareDefaultValue(): bool;
}
