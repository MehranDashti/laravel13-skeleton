<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

interface BaseRepositoryInterface
{
    public function getModel(): Model;
    public function create(array $payload, bool $setCreateFlag = true, bool $setUpdateFlag = true, bool $dispatcherEvent = true): Model;
    public function update(Model &$model, array $payload, bool $setUpdateFlag = true, bool $dispatcherEvent = true): void;
    public function delete(Model &$model, bool $setDeleteFlag = true): void;
    public function findByAttribute(string $attribute, mixed $value): ?Model;
    public function findInByAttribute(string $attribute, array $value, bool $getAsArray = false, array $toArrayAttribute = [], array $with = []): mixed;
    public function findOrCreate(array $attributeWithValue, array $attributes = []): Model;
    public function updateOrCreate(array $attributeWithValue, array $attributes = []): Model;
    public function setUserAction(Model &$model, string $attribute = 'created_by'): void;
    public function getAuthor(): ?string;
    public function changeStatus(Model &$model, string $status, string $attribute = 'status', bool $setUpdateFlag = true): Model;
    public function findAll(array $with = []): Collection;
    public function updateWithCondition(array $payload, array|string $values, string $field = 'id'): int;
    public function updateByConditions(array $conditions, array $payload): int;
    public function findByMetaData(array $metaData, string $returnType = 'first'): Model|Collection|null;
    public function deleteByMetaData(array $metaData): int;
    public function setSelectItems(array $items): self;
    public function getSelectItems(): array;
    public function setWithItems(array $items): self;
    public function getWithItems(): array;
}
