<?php

use Illuminate\Database\Seeder;

class PenjualSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pengguna')->insert([
            'email' => 'penjual@open_ecommerce',
            'nama'  => 'penjual',
            'sandi' => 'penjual',
            'peran' => 2,
            'konfirmasi' => 1
        ]);
    }
}
