<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Traits\BaseRepositoryTrait;

abstract class BaseRepository implements BaseRepositoryInterface
{
    use BaseRepositoryTrait;

    protected Model $model;
    protected array $selectItems = ['*'];
    protected array $withItems = [];

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function create(array $payload = [], bool $setCreateFlag = true, bool $setUpdateFlag = true, bool $dispatcherEvent = true): Model
    {
        $model = new $this->model();
        $model->fill($payload);
        if ($setCreateFlag) {
            $this->setUserAction($model);
        }
        if ($setUpdateFlag) {
            $this->setUserAction($model, 'updated_by');
        }
        if (! $dispatcherEvent) {
            $model->saveQuietly();
        } else {
            $model->saveOrFail();
        }
        $model->refresh();

        return $model;
    }

    public function update(Model &$model, array $payload, bool $setUpdateFlag = true, bool $dispatcherEvent = true): void
    {
        $model->fill($payload);
        if ($setUpdateFlag) {
            $this->setUserAction($model, 'updated_by');
        }
        if (! $dispatcherEvent) {
            $model->saveQuietly();
        } else {
            $model->saveOrFail();
        }
    }

    public function delete(Model &$model, bool $setDeleteFlag = true): void
    {
        if ($setDeleteFlag && $model->isFillable('deleted_by')) {
            $this->setUserAction($model, 'deleted_by');
            $model->saveOrFail();
        }
        $model->delete();
    }
}
