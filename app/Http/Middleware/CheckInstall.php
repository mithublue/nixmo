<?php

namespace App\Http\Middleware;

use Closure;

class CheckInstall
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
        if( !env('site_name' ) ) {
            return redirect()->route('install');
        }
        return $next($request);
    }
}
