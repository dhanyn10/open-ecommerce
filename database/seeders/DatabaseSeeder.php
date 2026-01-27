<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(AdminSeeder::class);
        $this->call(PenjualSeeder::class);
        $this->call(PembeliSeeder::class);
        $this->call(ProductSeeder::class);
    }
}
