<?php

namespace App\Services\Contracts;

use Illuminate\Database\Eloquent\Model;

/**
 * Interface MetaDataServiceInterface
 *
 * @package App\Services\Contracts
 */
interface MetaDataServiceInterface
{
    /**
     * @param Model|null $model
     *
     * @return array
     */
    public function getMetaData(?Model $model = null): array;
}
