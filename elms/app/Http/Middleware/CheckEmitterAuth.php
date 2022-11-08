<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckEmitterAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next,$guard = null)
    {
        if (Auth::guard($guard)->check()) {

            if($guard == "emitters"){
                return redirect()->route('emitter.home');
//                return $next($request);
            }
            session()->flash('UnAuthorized');


        }
    }
}
