<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Journal::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'code' => $faker->unique()->slug(3),
        'active' => 1,
        'description' => $faker->text,
    ];
});

//$factory->afterCreating(App\Models\Journal::class, function ($journal, $faker) {
//    $journal->accounts()->save(factory(App\Account::class)->make());
//});
