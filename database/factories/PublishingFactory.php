<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Publishing::class, function (Faker $faker) {
    return [
        "name" => $faker->sentence(2),
        "code" => $faker->unique()->slug,
        "description" => $faker->text,
        "active" => true
    ];
});
