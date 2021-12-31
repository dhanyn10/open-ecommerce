<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\DB;

use Closure;
use Illuminate\Http\Request;

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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
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
