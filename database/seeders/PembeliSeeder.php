<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PembeliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pengguna')->insert([
            'email' => 'pembeli@open_ecommerce',
            'nama'  => 'pembeli',
            'sandi' => 'pembeli',
            'peran' => 3,
            'konfirmasi' => 1
        ]);
    }
}
