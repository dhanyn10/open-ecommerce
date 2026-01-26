<?php

namespace Database\Seeders;

use App\Models\User;
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
        User::create([
            'email' => 'penjual@open_ecommerce',
            'nama'  => 'penjual',
            'password' => 'penjual',
            'peran' => 2,
            'konfirmasi' => 1
        ]);
    }
}
