<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;
class AuthCookie
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
        if (!$request->hasHeader('authorization') && @$request->cookies->get('access_token_server')) {
            $request->headers->add(['authorization'=> "Bearer {$request->cookies->get('access_token_server')}"]);
        }
        
        return $next($request);
    }
}
