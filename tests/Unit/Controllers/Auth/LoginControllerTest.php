<?php
/**
 * Copyright (c) 2018-2019 "ИД Панорама"
 * Автор модуля: Дмитрий Поскачей (dposkachei@gmail.com)
 */

namespace Tests\Unit\Controllers\Auth;


use App\Http\Controllers\Auth\LoginController;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Провал валидации на уникальный телефон
     */
    public function testLoginError()
    {
        $oController = (new LoginController());

        $request = $this->request([
            'email' => 'wrong'.testData()->user['email'],
            'password' => testData()->user['password'],
        ]);

        try {
            $result = $oController->login($request);

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
        $this->actingAs(testData()->user());

        $oController = (new LoginController());

        $request = $this->request([
            'email' => testData()->user['email'],
            'password' => testData()->user['password_string'],
        ]);

        try {
            $this->assertTrue(!Auth::guest());

            $result = $oController->login($request);

            //dd($result);

            $this->assertTrue($result['success']);

            Auth::logout();

            $this->assertTrue(Auth::guest());

            $result = $oController->login($request);

            //dd($result);

            $this->assertTrue(!Auth::guest());
            $this->assertTrue($result['success']);

        } catch (\Throwable $e) {
            $this->assertTrue(false);
        }
    }
}
