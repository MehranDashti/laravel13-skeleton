<?php

namespace App\Mediators\Contracts;

use Illuminate\Http\Response;
use App\Services\Contracts\BaseServiceInterface;
use App\Repositories\Contracts\BaseRepositoryInterface;

/**
 * Class BaseMediator
 *
 * @package App\Mediators\Contracts
 */
abstract class BaseMediator implements BaseMediatorInterface
{
    /** @var BaseServiceInterface */
    private BaseServiceInterface $service;

    /** @var BaseRepositoryInterface */
    private BaseRepositoryInterface $repository;

    /**
     * BaseMediator constructor.
     */
    public function __construct()
    {
        if (method_exists($this, 'repositoryClass')) {
            $this->setRepository($this->repositoryClass());
        }
    }

    /**
     * @param BaseServiceInterface $service
     *
     * @return $this
     */
    public function setService(BaseServiceInterface $service): self
    {
        $this->service = $service;

        return $this;
    }

    /**
     * @return BaseServiceInterface
     */
    public function getService(): BaseServiceInterface
    {
        return $this->service;
    }

    /**
     * @param BaseRepositoryInterface $repository
     *
     * @return $this
     */
    public function setRepository(BaseRepositoryInterface $repository): self
    {
        $this->repository = $repository;

        return $this;
    }

    /**
     * @return BaseRepositoryInterface
     */
    public function getRepository(): BaseRepositoryInterface
    {
        return $this->repository;
    }

    /**
     * @param string $value
     * @param array $assertValues
     * @param string $message
     *
     * @return self
     */
    protected function checkAssertHasValue(string $value, array $assertValues, string $message): self
    {
        if (! in_array($value, $assertValues, true)) {
            throw new \RuntimeException($message, Response::HTTP_NOT_ACCEPTABLE);
        }

        return $this;
    }
}
