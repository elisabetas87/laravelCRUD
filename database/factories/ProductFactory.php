<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        //
        'name' => $faker->unique()->word,
        'price' => $faker->randomFloat(2,0,999999),
        'description' => $faker->sentence,
        'category_id'=>$faker->numberBetween(1,5),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime
    ];
});
