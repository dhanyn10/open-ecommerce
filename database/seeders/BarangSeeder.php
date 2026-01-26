<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class BarangSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $faker->addProvider(new \Faker\Provider\FakeCar($faker));

        $penjual = User::where('email', 'penjual@open_ecommerce')->first();

        if ($penjual) {
            for($x = 0; $x < 10; $x++) {
                Product::create([
                    'id'    => date("ymdhis").Str::random(7).'-404',
                    'user_id' => $penjual->id,
                    'nama'  => $faker->vehicle.'-404',
                    'harga' => rand(200000000, 500000000),
                    'berat' => rand(5,10),
                    'jumlah'    => rand(1,50),
                    'keterangan' => $faker->paragraphs(2, true)
                ]);
            }
        }
    }
}
