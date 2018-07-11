<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\DB;

use Closure;

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
    public function handle($request, Closure $next)
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
