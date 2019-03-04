<?php
/**
 * @copyright Copyright (c) 2018-2019 "ИД Панорама"
 * @author    Дмитрий Поскачей (dposkachei@gmail.com)
 */

namespace Tests\Unit\Controllers\Auth;

use App\Http\Controllers\Auth\LoginController;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Tests\FactoryTrait;
use Tests\TestCase;

/**
 * Class for login controller test.
 */
class LoginControllerTest extends TestCase
{
    use DatabaseTransactions;
    use FactoryTrait;

    /**
     * @return LoginController
     */
    public function controller(): LoginController
    {
        return new LoginController();
    }

    /**
     * Провал валидации на уникальный телефон
     */
    public function testLoginError()
    {
        $oUser = $this->factoryMake(User::class);
        try {
            $result = $this->controller()->login($this->request([
                'email' => $oUser->email,
                'password' => $oUser->password,
            ]));
        } catch (\Exception $e) {
            // ValidationException code 422
            $this->assertTrue($e->status === 422);
        }
    }

    /**
     * Провал валидации на уникальный телефон
     */
    public function testLoginSuccess()
    {
        $user = $this->factoryUser([
            'password' => Hash::make('1234567890'),
        ]);

        $this->actingAs($user);

        try {
            $this->assertTrue(!Auth::guest());

            $result = $this->controller()->login($this->request([
                'email' => $user->email,
                'password' => '1234567890',
            ]));
            $this->assertTrue($result['success']);

            Auth::logout();
            $this->assertTrue(Auth::guest());


            $result = $this->controller()->login($this->request([
                'email' => $user->email,
                'password' => '1234567890',
            ]));
            $this->assertTrue(!Auth::guest());
            $this->assertTrue($result['success']);
        } catch (\Throwable $e) {
            $this->assertTrue(false);
        }
    }
}
