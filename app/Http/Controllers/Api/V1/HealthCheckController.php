<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

/**
 * Class HealthCheckController
 *
 * @package App\Http\Controllers\Api\V1\Private
 */
class HealthCheckController extends Controller
{
    /**
     * HealthCheckController constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->successResponse(
            trans('messages.action_successfully_done'),
            [
                'app_name' => config('app.name'),
                'environment' => app()->environment(),
            ]
        );
    }
}
