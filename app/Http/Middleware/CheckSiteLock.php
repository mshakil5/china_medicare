<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSiteLock
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if ($request->is('manage/*')) {
            return $next($request);
        }

        if (filter_var(env('SITE_LOCKED'), FILTER_VALIDATE_BOOLEAN)) {
            return response()->view('frontend.notification', [], 503);
        }

        return $next($request);
    }
}
