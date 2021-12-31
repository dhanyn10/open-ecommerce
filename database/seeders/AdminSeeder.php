<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pengguna')->insert([
            'email' => 'admin@open_ecommerce',
            'nama'  => 'admin',
            'sandi' => 'admin',
            'peran' => 1,
            'konfirmasi' => 1
        ]);
    }
}
