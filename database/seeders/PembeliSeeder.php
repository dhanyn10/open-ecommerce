<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class PembeliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => 'pembeli@open_ecommerce',
            'nama'  => 'pembeli',
            'password' => 'pembeli',
            'peran' => 3,
            'konfirmasi' => 1
        ]);
    }
}
