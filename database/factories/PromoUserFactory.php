<?php
/**
 * Copyright (c) 2018-2019 "ИД Панорама"
 * Автор модуля: Дмитрий Поскачей (dposkachei@gmail.com)
 */

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\PromoUser::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'user_id' => function () {
            return factory(App\Models\User::class)->create()->id;
        },
        'phone' => mt_rand(10000000000, 79999999999),
    ];
});
