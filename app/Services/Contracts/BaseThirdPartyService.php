<?php

namespace App\Services\Contracts;

use App\Facades\Contracts\BaseFacade;
use App\Services\Traits\BaseServiceTrait;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class BaseThirdPartyService
 *
 * @package App\Services\Contracts
 */
abstract class BaseThirdPartyService implements BaseServiceInterface
{
    use BaseServiceTrait;

    /** @var BaseFacade $facade */
    protected BaseFacade $facade;

    /**
     * BaseThirdPartyService constructor.
     *
     * @param BaseFacade $facade
     *
     * @throws BindingResolutionException
     */
    public function __construct(BaseFacade $facade)
    {
        $this->facade = $facade;
        if ($this instanceof HasMediatorInterface) {
            $this->mediator = $this->mediatorClass();
        }
    }
}
