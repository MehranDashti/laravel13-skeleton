<?php

namespace App\Http\Controllers\Api\V1;

use Exception;
use App\DTO\Auth\SampleDTO;
use App\Services\SampleService;
use Illuminate\Http\JsonResponse;
use App\Http\Filters\SampleFilter;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\SampleRequest;
use App\Http\Resources\SampleResource;

/**
 * Class SampleController
 *
 * @package App\Http\Controllers\Api\V1
 */
class SampleController extends Controller
{
    /**
     * ContactUsController constructor.
     *
     * @param SampleService $service
     */
    public function __construct(private SampleService $service)
    {
    }

    /**
     * @param SampleFilter $filter
     *
     * @return JsonResponse
     */
    public function index(SampleFilter $filter): JsonResponse
    {
        return $this->successResponse(
            trans('messages.action_successfully_done'),
            $this->service->getFilter(
                filter: $filter,
                resource: SampleResource::class
            )
        );
    }

    /**
     * @param SampleRequest $request
     *
     * @return JsonResponse
     */
    public function update(SampleRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $dto = app()->make(SampleDTO::class)->fromRequest($request);
            $this->service->sample($dto);
            DB::commit();

            return $this->successResponse(
                trans('messages.action_successfully_done'),
            );
        } catch (Exception $exception) {
            DB::rollBack();

            return $this->failureResponse(
                $exception->getMessage(),
                $exception
            );
        }
    }
}
