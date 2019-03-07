<?php
/**
 * @copyright Copyright (c) 2018-2019 "ИД Панорама"
 * @author Дмитрий Поскачей (dposkachei@gmail.com)
 */

use Faker\Generator as Faker;

$factory->define(App\Models\Activations::class, function (Faker $faker) {
    return [
        'code' => (new \App\Services\Code())->getConfirmationPromoCode(),
    ];
});
