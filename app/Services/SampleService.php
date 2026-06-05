<?php

namespace App\Services;

use App\Mediators\SampleMediator;
use App\Services\Traits\WebFilter;
use Agog\Osmose\Library\OsmoseFilter;
use App\Services\Contracts\BaseService;
use Illuminate\Database\Eloquent\Model;
use App\Services\Contracts\DataServiceInterface;
use App\Mediators\Contracts\BaseMediatorInterface;
use App\Repositories\Contracts\SampleRepositoryInterface;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class UserService
 *
 * @package App\Services
 */
final class SampleService extends BaseService implements DataServiceInterface
{
    use WebFilter;

    /**
     * UserService constructor.
     *
     * @param SampleRepositoryInterface $repository
     *
     * @throws BindingResolutionException
     */
    public function __construct(SampleRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @return BaseMediatorInterface
     *
     * @throws BindingResolutionException
     */
    public function mediatorClass(): BaseMediatorInterface
    {
        return app()->make(SampleMediator::class);
    }

    /**
     * @param OsmoseFilter $filter
     * @param Model|null $model
     * @param string|null $resource
     * @param array $conditions
     *
     * @return array
     */
    public function getFilter(OsmoseFilter $filter, ?Model $model = null, ?string $resource = null, array $conditions = []): array
    {
        return $this->filter($filter, $this->repository->getModel())
            ->sortModel($this->queryInfo()['sort'])
            ->orderBy('created_at', 'DESC')
            ->addListConditions($conditions)
            ->paginate()
            ->renderFilter($resource);
    }
}
