<?php

namespace App\Http\Middleware;
use Closure;
use Cache;
use Helper;

class CacheGet
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $route_key)
    {    

            if(in_array($request->method(), ['GET'])){
                $key = $route_key;
                
                if(Cache::store('file')->has($key)){
                    return response(Cache::store('file')->get($key));
                }
            }
            return $next($request);
    }
    
}
