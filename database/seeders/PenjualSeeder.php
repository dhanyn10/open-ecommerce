<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            'password' => Hash::make('penjual'),
            'peran' => 2,
            'konfirmasi' => 1
        ]);
    }
}
