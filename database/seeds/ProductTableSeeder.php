<?php

use App\Product;
use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Product::truncate();

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 50; $i++) {
            Product::create([
                'user_id' => $faker->unique()->numberBetween($min = 1, $max = 10000),
                'category_id' => $faker->unique()->numberBetween($min = 1, $max = 10000),
                'name' => $faker->sentence,
                'image' => $faker->image(),
                'price' => $faker->randomDigit,
                'quantity' => $faker->randomDigit,
            ]);
        }

    }
}

//'user_id' => $this->getRandomUserId(), //$faker->unique()->numberBetween($min = 1, $max = 10000),
