<?php

namespace App\Services\Traits;

use Closure;
use Agog\Osmose\Library\OsmoseFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * Trait WebFilter
 *
 * @package App\Traits
 */
trait WebFilter
{
    /**
     * @var Builder $builder
     */
    private $builder;

    /**
     * @param array<string> $columns
     *
     * @return Collection
     */
    public function get($columns = ['*']): Collection
    {
        $builder = $this->builder->applyScopes();
        if (count($models = $builder->getModels($columns)) > 0) {
            $models = $builder->eagerLoadRelations($models);
        }

        return $builder->getModel()->newCollection($models);
    }

    /**
     * @param array $relations
     *
     * @return $this
     */
    public function with(array $relations): self
    {
        $this->builder = $this->builder->with($relations);

        return $this;
    }

    /**
     * @param array $columns
     *
     * @return $this
     */
    public function select(array $columns): self
    {
        $this->builder = $this->builder->select($columns);

        return $this;
    }

    /**
     * @param string $column
     * @param string $type
     *
     * @return $this
     */
    public function orderBy(string $column, string $type): self
    {
        $this->builder = $this->builder->orderBy($column, $type);

        return $this;
    }

    /**
     * @param mixed ...$groups
     *
     * @return $this
     */
    public function groupBy(...$groups)
    {
        $this->builder = $this->builder->groupBy($groups);

        return $this;
    }

    /**
     * @param string $column
     * @param array $payload
     *
     * @return $this
     */
    public function whereIn(string $column, array $payload): self
    {
        $this->builder = $this->builder->whereIn($column, $payload);

        return $this;
    }

    /**
     * @param mixed $column
     * @param mixed $operator
     * @param mixed $value
     *
     * @return $this
     */
    public function where($column, $operator = null, $value = null): self
    {
        $this->builder = $this->builder->where($column, $operator, $value);

        return $this;
    }

    /**
     * @param $relation
     * @param Closure|null $callback
     * @param string $operator
     * @param int $count
     *
     * @return mixed
     */
    public function whereHas($relation, ?Closure $callback = null, $operator = '>=', $count = 1): self
    {
        $this->builder = $this->builder->has($relation, $operator, $count, 'and', $callback);

        return $this;
    }

    /**
     * @param array $payload
     *
     * @return $this
     */
    public function options(array $payload): self
    {
        if (app()->environment() !== 'testing') {
            $this->builder = $this->builder->options($payload);
        }

        return $this;
    }

    /**
     * @param OsmoseFilter $filter
     * @param Model $model
     *
     * @return $this
     */
    protected function filter(OsmoseFilter $filter, Model $model): self
    {
        $this->builder = $filter->sieve($model::class);

        return $this;
    }

    /**
     * @param string $resource
     *
     * @return array
     */
    protected function renderFilter(string $resource): array
    {
        return [
            'list' => $resource::collection($this->builder),
            'pagination' => [
                'total' => $this->builder->total(),
                'current' => $this->builder->currentPage(),
                'page_size' => $this->queryInfo()['page_size'],
            ],
        ];
    }

    /**
     * @param string $resource
     * @param Collection $collection
     *
     * @return array
     */
    protected function renderFuzzySearch(string $resource, Collection $collection): array
    {
        return [
            'list' => $resource::collection($collection),
            'pagination' => [
                'total' => $collection->count(),
                'current' => 1,
                'page_size' => $collection->count(),
            ],
        ];
    }

    /**
     * @param int|null $pagination
     *
     * @return $this
     */
    protected function paginate(?int $pagination = null): self
    {
        $queryInfo = $this->queryInfo();
        if (! $pagination) {
            if (! $queryInfo['page_size']) {
                $pagination = 100000;
            } else {
                $pagination = $queryInfo['page_size'];
            }
        }

        $this->builder = $this->builder->paginate((int) $pagination, ['*'], 'page', (int) $queryInfo['currentPage']);

        return $this;
    }

    /**
     * @param array $sort
     *
     * @return $this
     */
    protected function sortModel(array $sort): self
    {
        if ($sort !== []) {
            $this->builder = $this->builder->orderBy(array_key_first($sort), $this->getSortMap()[reset($sort)]);
        }

        return $this;
    }

    /**
     * @return array
     */
    protected function queryInfo(): array
    {
        $pageSize = (int) request()->query('page_size');
        if ($pageSize < 1) {
            $pageSize = request()->query('pageSize');
        }
        if (! $pageSize) {
            $pageSize = 100000;
        }
        $currentPage = request()->query('current');
        if ($currentPage === null) {
            $currentPage = request()->query('page');
        }

        return [
            'page_size' => $pageSize ?? $this->getServicePaginate(),
            'currentPage' => $currentPage ? $currentPage : '1',
            'sort' => json_decode(request()->query('sorter'), true) ?: [],
        ];
    }

    /**
     * @param string $relation
     * @param array $conditions
     *
     * @return self
     */
    protected function considerLanguageFilter(string $relation, string $language, array $conditions = []): self
    {
        if ($conditions) {
            $this->whereHas($relation, function (Builder $indentQuery) use ($language) {
                return $indentQuery->where('language', '=', $language);
            });
        }

        return $this;
    }

    /**
     * @return array
     */
    private function getSortMap(): array
    {
        return [
            'ascend' => 'ASC',
            'descend' => 'DESC',
        ];
    }
}
