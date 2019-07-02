<?php

use Faker\Generator as Faker;

$factory->define(App\Category::class, function (Faker $faker) {
    return [
        //
        'name' => $faker->unique()->word,
        'description' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime
            
            //probar:
            //'XXXX' => $faker->firstname,
            //'XXXX' => $faker->lastname,
            //'XXXX' => $faker->postcode,
            //'XXXX' => $faker->state
            //'XXXX' => $faker->randomElement(['ES','CA']): no va
            
    ];
});
