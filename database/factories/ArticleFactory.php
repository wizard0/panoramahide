<?php

use Faker\Generator as Faker;

$factory->define(App\Article::class, function (Faker $faker) {
    if (!$release = App\Release::first())
    {
        $journal = factory(\App\Journal::class)->create();
        $release = factory(\App\Release::class)->create(['journal_id' => $journal->id]);
    }

    return [
        'name' => $faker->sentence(3),
        'code' => $faker->unique()->slug(3),
        'description' => $faker->text,
        'price' => $faker->randomNumber(3),
        'price' => rand(100,500),
        'release_id' => $release->id
    ];
});
