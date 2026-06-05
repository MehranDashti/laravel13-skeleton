<?php

namespace App\Http\Requests\Traits;

use App\Http\Requests\Contracts\RequestDefaultValueInterface;

/**
 * Trait RequestDefaultValuesTrait
 *
 * @package App\Http\Requests\Traits
 */
trait RequestDefaultValueTrait
{
    public function prepareDefaultValue(): bool
    {
        if (! $this instanceof RequestDefaultValueInterface) {
            return false;
        }

        foreach ($this->defaultValues() as $key => $defaultValue) {
            if (! $this->has($key)) {
                $this->merge([$key => $defaultValue]);
            }
        }

        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->prepareDefaultValue();
    }
}
