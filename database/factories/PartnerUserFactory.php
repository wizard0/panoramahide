<?php

use Faker\Generator as Faker;

$factory->define(App\Models\PartnerUser::class, function (Faker $faker) {
    return ['user_id' => md5(rand(0, 99999) . time()),
        'email' => md5(rand(0, 99999) . time()) . '@mail.ru',
        'active' => true,
        'partner_id' => function () {
            return factory(App\Models\Partner::class)->create()->id;
        }
    ];
});
