<?php

namespace App\Services\Contracts;

use Illuminate\Database\Eloquent\Model;
use App\Services\Traits\BaseServiceTrait;
use App\DTO\Contracts\ToArrayDTOInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class BaseService
 *
 * @package App\Services\Contracts
 */
abstract class BaseService implements BaseServiceInterface, BaseDatabaseServiceInterface
{
    use BaseServiceTrait;

    /** @var BaseRepositoryInterface $repository */
    protected BaseRepositoryInterface $repository;

    /**
     * BaseService constructor.
     *
     * @param BaseRepositoryInterface $repository
     *
     * @throws BindingResolutionException
     */
    public function __construct(BaseRepositoryInterface $repository)
    {
        $this->repository = $repository;
        if ($this instanceof HasMediatorInterface) {
            $this->mediator = $this->mediatorClass();
        }
    }

    /**
     * @param Model $model
     * @param string $resourceNameSpace
     *
     * @return JsonResource
     */
    public function getView(Model $model, string $resourceNameSpace): JsonResource
    {
        return new $resourceNameSpace($model);
    }

    /**
     * @param Model $model
     * @param ToArrayDTOInterface $dto
     *
     * @return Model
     */
    public function update(Model $model, ToArrayDTOInterface $dto): Model
    {
        $this->repository->update($model, $dto->toArray());

        return $model;
    }

    /**
     * @param Model $model
     * @param string $foreignKey
     * @param array $attributes
     * @param array $extraData
     *
     * @return Model
     */
    public function log(Model $model, string $foreignKey, array $attributes, array $extraData = []): Model
    {
        $model->refresh();
        $payload = [];

        foreach ($attributes as $attribute) {
            $payload[$attribute] = $model->getAttribute($attribute);
        }
        $payload[$foreignKey] = $model->id;

        return $this->repository->create($payload);
    }

    /**
     * @param array $conditions
     *
     * @return $this
     */
    protected function addListConditions(array $conditions = []): self
    {
        foreach ($conditions as $field => $value) {
            if (is_array($value)) {
                $this->whereIn($field, $value);
            } else {
                $this->where($field, $value);
            }
        }

        return $this;
    }
}
