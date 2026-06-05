<?php

namespace App\Repositories\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

trait BaseRepositoryTrait
{
    public function findByAttribute(string $attribute, mixed $value): ?Model
    {
        return $this->model::where($attribute, $value)
            ->select($this->getSelectItems())
            ->with($this->getWithItems())
            ->first();
    }

    public function findInByAttribute(string $attribute, array $value, bool $getAsArray = false, array $toArrayAttribute = [], array $with = []): mixed
    {
        $query = $this->model::whereIn($attribute, $value);
        if ($with) {
            $query = $query->with($with);
        }
        if ($getAsArray) {
            return $query->get($toArrayAttribute)->toArray();
        }

        return $query->get();
    }

    public function findOrCreate(array $attributesWithValues, array $attributes = []): Model
    {
        $model = $this->model::where($attributesWithValues)->first();
        if (! $model) {
            $attributes = array_merge($attributes, $attributesWithValues);
            $model = $this->create($attributes);
        }

        return $model;
    }

    public function updateOrCreate(array $attributeWithValue, array $attributes = []): Model
    {
        $model = $this->model::where($attributeWithValue)->first();
        $attributes = array_merge($attributes, $attributeWithValue);
        if (! $model) {
            $model = $this->create($attributes);
        } else {
            $model->fill($attributes)->save();
        }

        return $model;
    }

    public function setUserAction(Model &$model, string $attribute = 'created_by'): void
    {
        $model->setAttribute($attribute, $this->getAuthor());
    }

    public function getAuthor(): ?string
    {
        $user = Auth::guard('api')->user();

        return $user?->phone;
    }

    public function changeStatus(Model &$model, string $status, string $attribute = 'status', bool $setUpdateFlag = true): Model
    {
        $model->setAttribute($attribute, $status);
        if ($setUpdateFlag) {
            $this->setUserAction($model, 'updated_by');
        }
        $model->save();

        return $model;
    }

    public function findAll(array $with = []): Collection
    {
        return $this->model::with($with)->get();
    }

    public function updateWithCondition(array $payload, array|string $values, string $field = 'id'): int
    {
        return $this->model::whereIn($field, (array) $values)->update($payload);
    }

    public function updateByConditions(array $conditions, array $payload): int
    {
        return $this->model::where($conditions)->update($payload);
    }

    public function findByMetaData(array $metaData, string $returnType = 'first', mixed $limitCount = null): Model|Collection|null
    {
        $query = $this->model::where($metaData);
        if ($limitCount) {
            $query->limit($limitCount);
        }

        return $returnType === 'first' ? $query->first() : $query->get();
    }

    public function deleteByMetaData(array $metaData): int
    {
        return $this->model::where($metaData)->delete();
    }

    public function setSelectItems(array $items): static
    {
        $this->selectItems = $items;

        return $this;
    }

    public function getSelectItems(): array
    {
        return $this->selectItems;
    }

    public function setWithItems(array $items): static
    {
        $this->withItems = $items;

        return $this;
    }

    public function getWithItems(): array
    {
        return $this->withItems;
    }
}
