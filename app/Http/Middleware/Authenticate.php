<?php

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Closure;
use \Symfony\Component\HttpFoundation\Response;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }

    public function handle($request, Closure $next, ...$guards)
    {
        try {
            $this->authenticate($request, $guards);
        } catch (AuthenticationException $exception) {
            return response()->json([
                'message' => 'Unauthenticated.',
                'success' => false,
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
