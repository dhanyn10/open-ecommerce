<?php

namespace App\Http\Middleware;

use Closure;

class Pembeli
{
    public function handle($request, Closure $next)
    {
        if(session('peran') != 3)
        {
            flash('silahkan login dulu');
            return redirect()->route('masuk');
        }
        return $next($request);
    }
}
