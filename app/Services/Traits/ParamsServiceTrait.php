<?php

namespace App\Services\Traits;

/**
 * Trait ParamsServiceTrait
 *
 * @package App\Services\Traits
 */
trait ParamsServiceTrait
{
    /**
     * @param array $keys
     * @param array $defaultParams
     *
     * @return array
     */
    private function prepareGetParams(array $keys, array $defaultParams = []): array
    {
        foreach ($keys as $key) {
            if (request()->input($key)) {
                $defaultParams[$key] = request()->input($key);
            }
        }

        return $defaultParams;
    }
}
