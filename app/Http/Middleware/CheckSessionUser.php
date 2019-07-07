<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class CheckSessionUser
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
        if ($request->session()->has('dataUser')) {
            return $next($request);
        }else{
            return response()->json(['status'=>'HTTP_UNAUTHORIZED !!','code' => Response::HTTP_UNAUTHORIZED],Response::HTTP_UNAUTHORIZED);
        }
    }
}
