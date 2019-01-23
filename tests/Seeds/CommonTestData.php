<?php

namespace Tests\Seeds;

use App\Models\PromoUser;
use App\User;

/**
 * Можно вызывать через хелпер
 * testData() - @see config/helpers.php
 * @see testData()
 *
 * Class CommonTestData
 * @package Tests\Seeds
 */
class CommonTestData
{

    /**
     * Пользователь
     *
     * @var array
     */
    public $user = [
        'name' => 'Тестовый',
        'email' => 'test@test.com',
        'password' => '$2y$10$pf83r3UTfcTuGMCfU0M0neords7hON3fEMAThuxvlwwbDpndd1W72', // testtets
        'phone' => '79998887766',
    ];

    /**
     * Модель пользователя
     *
     * @return mixed
     */
    public function user()
    {
        return User::where('email', testData()->user['email'])->first();
    }

    /**
     * Модель пользователя
     *
     * @return mixed
     */
    public function promoUser()
    {
        return PromoUser::where('user_id', testData()->user()->id)->first();
    }
}
