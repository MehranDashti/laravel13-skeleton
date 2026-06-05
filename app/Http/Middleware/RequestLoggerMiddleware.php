<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class RequestLoggerMiddleware
 *
 * @package App\Http\Middleware
 */
class RequestLoggerMiddleware
{
    /**
     * @param $request
     * @param Closure $next
     *
     * @return mixed
     *
     * @throws BindingResolutionException
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $this->createLog($request, $response);

        return $response;
    }

    /**
     * @param Request $request
     * @param $response
     *
     * @return bool
     *
     * @throws BindingResolutionException
     */
    private function createLog(Request $request, $response): bool
    {
        if (app()->environment() === 'testing' || ! $response instanceof JsonResponse) {
            return false;
        }
        $requestStatus = $this->handleStatus($response->getStatusCode());
        $level = $requestStatus['level'];
        $errors = $response->getOriginalContent()['error'] ?? null;
        $payload = [
            'ip' => getRealIp(),
            'created_at' => Carbon::now()->toIso8601String(),
            'level' => $level,
            'message' => $requestStatus['message'],
            'status_code' => $response->getStatusCode(),
            'url' => request()->getRequestUri(),
            'method' => request()->getRealMethod(),
            'payload' => $request->all(),
            'query_params' => $request->getQueryString(),
            'headers' => request()->header(),
            'errors' => [
                'message' => $response->getOriginalContent()['message'] ?? null,
                'errors' => app()->environment() === 'production' ? $errors : [],
            ],
        ];
        Log::channel('request_log')->$level($requestStatus['message'], $payload);

        return true;
    }

    /**
     * @param int $statusCode
     *
     * @return array
     */
    private function handleStatus(int $statusCode): array
    {
        if ($statusCode >= 200 && $statusCode < 300) {
            return [
                'level' => 'info',
                'message' => 'Successful request.',
            ];
        }

        if ($statusCode >= 400 && $statusCode < 500) {
            return [
                'level' => 'alert',
                'message' => 'Client Failed.',
            ];
        }

        if ($statusCode >= 500 && $statusCode < 600) {
            return [
                'level' => 'critical',
                'message' => 'Internal Server Failed.',
            ];
        }

        return [
            'level' => 'error',
            'message' => 'Gateway Failed.',
        ];
    }
}
