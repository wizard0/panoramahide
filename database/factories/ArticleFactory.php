<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Article::class, function (Faker $faker) {
    if (!$release = App\Models\Release::first()) {
        $journal = factory(\App\Models\Journal::class)->create();
        $release = factory(\App\Models\Release::class)->create(['journal_id' => $journal->id]);
    }

    return [
        'name' => $faker->sentence(3),
        'code' => $faker->unique()->slug(3),
        'description' => $faker->text,
        'price' => rand(100, 500),
        'release_id' => $release->id
    ];
});
