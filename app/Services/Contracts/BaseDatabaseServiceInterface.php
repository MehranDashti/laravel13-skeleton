<?php

namespace App\Services\Contracts;

use Illuminate\Database\Eloquent\Model;
use App\DTO\Contracts\ToArrayDTOInterface;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Interface BaseDatabaseServiceInterface
 *
 * @package App\Services\Contracts
 */
interface BaseDatabaseServiceInterface
{
    /**
     * @param Model $model
     * @param string $resourceNameSpace
     *
     * @return JsonResource
     */
    public function getView(Model $model, string $resourceNameSpace): JsonResource;

    /**
     * @param Model $model
     * @param ToArrayDTOInterface $dto
     *
     * @return Model
     */
    public function update(Model $model, ToArrayDTOInterface $dto): Model;

    /**
     * @param Model $model
     * @param string $foreignKey
     * @param array $attributes
     * @param array $extraData
     *
     * @return Model
     */
    public function log(Model $model, string $foreignKey, array $attributes, array $extraData = []): Model;
}
