<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class adminPermission
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
        if(auth::user()->type=='Admin' || auth::user()->type=='SuperAdmin'){
            return $next($request);
        }
        else{
            return redirect('/home');
            exit;
        }


    }
}
