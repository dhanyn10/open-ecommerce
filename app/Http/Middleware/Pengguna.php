<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class Pengguna
{
    
    protected function connect()
    {
        try
        {
            DB::connection()->getPdo();
        }
        catch(\PDOException $e)
        {
            return "koneksi database gagal";
        }
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($this->connect() == "koneksi database gagal")
        {
            flash('terjadi kesalahan koneksi database')->error();
            return redirect()->route('beranda');
        }
        if(session('email') == null)
        {
            flash('silahkan login dulu');
            return redirect()->route('masuk');
        }
        return $next($request);
    }
}
