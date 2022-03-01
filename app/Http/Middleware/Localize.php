<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;

class Localize
{

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->hasHeader('X-locale')) {
            app()->setLocale($request->header('X-locale'));
        }
        return $next($request);
   }
}
