<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Partner::class, function (Faker $faker) {
    return [
        'secret_key' => md5(rand(0, 9999) . time()),
        'active' => true
    ];
});
