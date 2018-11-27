<?php

use Faker\Generator as Faker;

$factory->define(App\Publishing::class, function (Faker $faker) {
    return [
        "name" => $faker->sentence(2),
        "code" => $faker->unique()->slug,
        "active" => true
    ];
});
