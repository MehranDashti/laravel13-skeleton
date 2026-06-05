<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;

/**
 * Class SecretKeyMiddleware
 *
 * @package App\Http\Middleware
 */
class SecretKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     *
     * @throws AuthenticationException
     */
    public function handle($request, Closure $next)
    {
        if ($request->header('allowed_secret') === config('settings.allowed_secret')) {
            return $next($request);
        }

        throw new AuthenticationException('Secret key not match');
    }
}
