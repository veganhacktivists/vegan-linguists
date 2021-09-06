<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TranslatorUserMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->isInAuthorMode()) {
            $request->user()->switchUserMode();
        }
        return $next($request);
    }
}
