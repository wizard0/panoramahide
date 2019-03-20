<?php
/**
 * @copyright Copyright (c) 2018-2019 "ИД Панорама"
 * @author    Денис Парыгин (dyp2000@mail.ru)
 */
use Faker\Generator as Faker;

$factory->define(App\Models\UserFavorite::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(App\Models\User::class)->create()->id;
        },
        'element_id' => function () {
            return factory(App\Models\Article::class)->create()->id;
        },
        'type' => App\Models\UserFavorite::TYPE_ARTICLE
    ];
});
