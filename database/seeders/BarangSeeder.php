<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use App\Models\Barang;

class BarangSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $faker->addProvider(new \Faker\Provider\FakeCar($faker));
        for($x = 0; $x < 10; $x++) {
            Barang::create([
                'id'    => date("ymdhis").Str::random(7).'-404',
                'nama'  => $faker->vehicle.'-404',
                'harga' => rand(200000000, 500000000),
                'berat' => rand(5,10),
                'jumlah'    => rand(1,50),
                'penjual'   => 'penjual@open_ecommerce',
                'keterangan' => $faker->paragraphs(2, true)
            ]);
        }
    }
}
