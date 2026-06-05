<?php

namespace App\Services\Contracts;

use Agog\Osmose\Library\OsmoseFilter;
use Illuminate\Database\Eloquent\Model;

/**
 * Interface OrderServiceInterface
 *
 * @package App\Services\Contracts
 */
interface DataServiceInterface
{
    /**
     * @param OsmoseFilter $filter
     * @param Model|null $model
     * @param string|null $resource
     * @param array $conditions
     *
     * @return array
     */
    public function getFilter(OsmoseFilter $filter, ?Model $model = null, ?string $resource = null, array $conditions = []): array;
}
