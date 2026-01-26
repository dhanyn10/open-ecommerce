<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            'password' => Hash::make('admin'),
            'peran' => 1,
            'konfirmasi' => 1
        ]);
    }
}
