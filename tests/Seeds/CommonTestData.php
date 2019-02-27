<?php

namespace Tests\Seeds;

use App\Models\Promocode;
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
        'password' => '$2y$10$pf83r3UTfcTuGMCfU0M0neords7hON3fEMAThuxvlwwbDpndd1W72', // testtest
        'password_string' => 'testtest', // testtest
        'phone' => '79998887766',
        'phone_second' => '79998887755', // второй телефон, чтобы не повторялся
    ];

    public $userDevice = [
        'code' => 100000,
        'name' => 'Windows:WebKit:Chrome',
    ];

    /**
     * Модель пользователя
     *
     * @return mixed
     */
    public function user()
    {
        $oUser = User::where('email', testData()->user['email'])->first();
        if (is_null($oUser)) {
            $oUser = User::create([
                'name' => testData()->user['name'],
                'last_name' => testData()->user['name'],
                'email' => testData()->user['email'],
                'phone' => testData()->user['phone'],
                'password' => testData()->user['password'],
            ]);
        }
        return $oUser;
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

    public function generatePhone()
    {
        return mt_rand(10000000000, 79999999999);
    }

    /**
     * Активный промокод
     * - release_end > now()
     * - active = 1
     * - used < limit
     *
     * @return mixed
     */
    public function activePromocode()
    {
        $oPromoCodes = Promocode::where('release_end', '>', now())
            ->where('active', 1)
            ->get();
        $oPromoCodes = $oPromoCodes->reject(function ($item) {
            return $item->used >= $item->limit;
        });
        return $oPromoCodes->first();
    }

    /**
     * Не активный промокод
     * - release_end > now()
     * - active = 1
     * - used < limit
     *
     * @return mixed
     */
    public function notActivePromocode()
    {
        $oPromoCodes = Promocode::where('release_end', '>', now())
            ->where('active', 1)
            ->get();
        $oPromoCodes = $oPromoCodes->reject(function ($item) {
            return $item->used < $item->limit;
        });
        return $oPromoCodes->first();
    }
}
