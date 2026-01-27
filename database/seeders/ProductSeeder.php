<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $faker->addProvider(new \Faker\Provider\FakeCar($faker));
        $user = \App\Models\Pengguna::where('email', 'penjual@open_ecommerce')->first();
        if ($user) {
            for($x = 0; $x < 10; $x++) {
                Product::create([
                    'id'    => date("ymdhis").Str::random(7).'-404',
                    'name'  => $faker->vehicle.'-404',
                    'price' => rand(20000000, 50000000),
                    'weight' => rand(5,10),
                    'stock'    => rand(1,50),
                    'user_id'   => $user->id,
                    'description' => $faker->paragraphs(2, true)
                ]);
            }
        }
    }
}
