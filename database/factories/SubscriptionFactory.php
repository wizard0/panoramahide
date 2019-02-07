<?php

use Faker\Generator as Faker;

$factory->define(\App\Subscription::class, function (Faker $faker) {
    $randLocale = rand(0,1);
    $randType = rand(0,1);
    $randHalfYear = rand(0,1);
    $randPeriod = rand(0,4);

    $locale = [
        'ru', 'en'
    ];

    $type = [
        \App\Subscription::TYPE_PRINTED,
        \App\Subscription::TYPE_ELECTRONIC
    ];
    $halfYear = [
        \App\Subscription::HALFYEAR_1,
        \App\Subscription::HALFYEAR_2
    ];
    $period = [
        \App\Subscription::PERIOD_TWICE_MONTH,
        \App\Subscription::PERIOD_ONCE_MONTH,
        \App\Subscription::PERIOD_ONCE_2_MONTH,
        \App\Subscription::PERIOD_ONCE_3_MONTH,
        \App\Subscription::PERIOD_ONCE_HALFYEAR,
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
