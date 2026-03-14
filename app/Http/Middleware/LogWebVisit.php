<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogWebVisit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        activity('visitor-log')
            ->event('page-view')
            ->withProperties([
                'ip' => $request->ip(),
                'url' => $request->fullUrl(),
                'agent' => $request->userAgent(),
            ])
            ->log('User visited ' . $request->path());

        return $next($request);
    }

    
}
