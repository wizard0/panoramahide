<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Promocode::class, function (Faker $faker) {
    return [
        "promocode" => $faker->unique()->slug,
        "active" => $faker->randomElement([0, 1]),
        "type" => $faker->randomElement([
            'common',
            'on_journal',
            'on_publishing',
            'on_release',
            'publishing+release',
            'custom',
        ]),
        "limit" => $faker->numberBetween(1, 10),
        "used" => $faker->numberBetween(0, 5),
        "release_begin" =>  $faker->dateTimeBetween('-1 year'),
        "release_end" =>  $faker->dateTimeBetween('-1 year'),
        "release_limit" => $faker->numberBetween(0, 10),
    ];
});
