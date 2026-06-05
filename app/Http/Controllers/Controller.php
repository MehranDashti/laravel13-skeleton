<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Mehrand\ApiResponse\ApiResponse;

abstract class Controller
{
    /**
     * @param string $message
     * @param array $data
     *
     * @return JsonResponse
     */
    public function successResponse(string $message, $data = []): JsonResponse
    {
        return ApiResponse::successResponse()
            ->setMessage($message)
            ->setResponseValue($data)
            ->render();
    }

    /**
     * @param string $message
     * @param Exception|null $exception
     *
     * @return JsonResponse
     */
    public function failureResponse(string $message, ?Exception $exception = null): JsonResponse
    {
        $response = ApiResponse::failureResponse()
            ->setMessage($message);

        if ($exception instanceof Exception && $exception->getCode() > 0) {
            $response->setCode($exception->getCode());
        }

        return $response->render();
    }
}
