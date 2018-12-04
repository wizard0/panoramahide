<?php

use Faker\Generator as Faker;

$factory->define(App\Release::class, function (Faker $faker) {
    return [
        "name" => $faker->sentence(3),
        "code" => $faker->unique()->slug(3),
        "active" => true
    ];
});

//$factory->afterCreating(App\Release::class, function ($release, $faker) {
//    $release->journal()->save(factory(App\Journal::class)->make());
//});