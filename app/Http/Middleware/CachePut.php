<?php

namespace App\Http\Middleware;
use Closure;
use Cache;
use Helper;

class CachePut
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $route_key, $minutes)
    {   
        
         $req = $next($request);
         
         if(in_array($request->method(),['GET'])){
            $expiresAt = now()->addMinutes($minutes);
            $key = $route_key;
            if(!Cache::store('file')->has($key)){
                  Cache::store('file')->put($key, $req->getContent(), $expiresAt);    
            }
         }
         
          
          return $req;
    }
    
   
    
}
