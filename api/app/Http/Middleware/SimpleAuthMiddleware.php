<?php

namespace App\Http\Middleware;

use Closure;

class SimpleAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->header('Authorization') !== 'Basic ' . $_ENV['API_KEY']) {
            return response('Unauthorized.', 401);
        }

        return $next($request);
    }
}
