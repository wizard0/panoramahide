<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Author::class, function (Faker $faker) {
    return [
        'author_language' => 'ru',
        'name' => $faker->name()
    ];
});
