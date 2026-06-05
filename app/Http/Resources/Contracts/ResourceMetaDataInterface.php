<?php

namespace App\Http\Resources\Contracts;

use Illuminate\Database\Eloquent\Model;

/**
 * Interface ResourceMetaDataInterface
 *
 * @package App\Http\Resources\Contracts
 */
interface ResourceMetaDataInterface
{
    /**
     * @param Model $model
     *
     * @return array
     */
    public function getMetaData(Model $model): array;
}
