<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => 'admin@open_ecommerce',
            'nama'  => 'admin',
            'password' => 'admin',
            'peran' => 1,
            'konfirmasi' => 1
        ]);
    }
}
