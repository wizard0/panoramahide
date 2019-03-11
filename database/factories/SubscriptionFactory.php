<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Subscription::class, function (Faker $faker) {
    $randLocale = rand(0, 1);
    $randType = rand(0, 1);
    $randHalfYear = rand(0, 1);
    $randPeriod = rand(0, 4);

    $locale = [
        'ru', 'en'
    ];

    $type = [
        \App\Models\Subscription::TYPE_PRINTED,
        \App\Models\Subscription::TYPE_ELECTRONIC
    ];
    $halfYear = [
        \App\Models\Subscription::HALFYEAR_1,
        \App\Models\Subscription::HALFYEAR_2
    ];
    $period = [
        \App\Models\Subscription::PERIOD_TWICE_MONTH,
        \App\Models\Subscription::PERIOD_ONCE_MONTH,
        \App\Models\Subscription::PERIOD_ONCE_2_MONTH,
        \App\Models\Subscription::PERIOD_ONCE_3_MONTH,
        \App\Models\Subscription::PERIOD_ONCE_HALFYEAR,
    ];

    return [
        'locale' => $locale[$randLocale],
        'active' => 1,
        'type' => $type[$randType],
        'year' => date("Y"),
        'half_year' => $halfYear[$randHalfYear],
        'period' => $period[$randPeriod],
        'price_for_release' => rand(100, 300),
        'price_for_half_year' => rand(600, 1800),
        'price_for_year' => rand(1200, 3600)
    ];
});
