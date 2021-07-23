<?php

namespace App\Http\Middleware;

use Closure;

class Admin
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
        if(session('peran') != 1)
        {
            flash('silahkan login dulu');
            return redirect()->route('masuk');
        }
        return $next($request);
    }
}
