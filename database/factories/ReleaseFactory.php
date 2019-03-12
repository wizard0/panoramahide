<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Release::class, function (Faker $faker) {
    $images = [ '/upload/1bbd2957617fae1ae419bcc9375c7687.png',
                '/upload/8f713e2c915dd7e8c5f211d0473aeced.png',
                '/upload/061b50ac1a73c58bd61c82fcdadc75c5.png',
                '/upload/76e560444bfda76a6cd0da3e9ad608f8.png',
                '/upload/6078be6895408d6b8918f70712263b5c.png',
                '/upload/b016f88622963cdc46470abb872ec913.png',
                '/upload/e520a8ddd9aeb73af8fa67452f8011de.png',
                '/upload/e0520b5fd8405b40cebf75828e7527ec.gif'
              ];
    return [
        'name' => $faker->sentence(3),
        'image' => $images[rand(0, count($images)-1)],
        'number' => $faker->randomNumber(2),
        'code' => $faker->unique()->slug(3),
        'price_for_electronic' => $faker->randomNumber(3),
        'price_for_printed' => $faker->randomNumber(3),
        'price_for_articles' => $faker->randomNumber(3),
        'active' => true
    ];
});

//$factory->afterCreating(App\Models\Release::class, function ($release, $faker) {
//    $release->journal()->save(factory(App\Journal::class)->make());
//});
