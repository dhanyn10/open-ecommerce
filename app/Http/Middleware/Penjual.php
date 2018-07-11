<?php

namespace App\Http\Middleware;

use Closure;

class Penjual
{
    public function handle($request, Closure $next)
    {
        if(session('peran') != 2)
        {
            flash('silahkan login dulu');
            return redirect()->route('masuk');
        }
        return $next($request);
    }
}
