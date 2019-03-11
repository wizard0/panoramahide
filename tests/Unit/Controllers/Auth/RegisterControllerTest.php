<?php
/**
 * @copyright Copyright (c) 2018-2019 "ИД Панорама"
 * @author    Дмитрий Поскачей (dposkachei@gmail.com)
 */

namespace Tests\Unit\Controllers\Auth;

use App\Http\Controllers\Auth\RegisterController;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Tests\FactoryTrait;
use Tests\TestCase;

/**
 * Class for register controller test.
 */
class RegisterControllerTest extends TestCase
{
    use DatabaseTransactions;
    use FactoryTrait;

    /**
     * @var User
     */
    private $user;

    /**
     * Создание сущностей
     */
    protected function setUp()
    {
        parent::setUp();
    }

    /**
     * @return RegisterController
     */
    public function controller(): RegisterController
    {
        return new RegisterController();
    }

    /**
     * Провал валидации на уникальный телефон
     */
    public function testRegisterValidationPhoneUnique()
    {
        $oUser = $this->factoryUser();
        try {
            $result = $this->controller()->register($this->request($this->registerData([
                'phone' => $oUser->phone,
            ])));
        } catch (\Throwable $e) {
            // ValidationException code 422
            $this->assertTrue($e->status === 422);
        }
    }

    /**
     * Провал валидации на уникальный email
     */
    public function testRegisterValidationEmailUnique()
    {
        $oUser = $this->factoryUser();
        try {
            $result = $this->controller()->register($this->request($this->registerData([
                'email' => $oUser->email,
            ])));
        } catch (\Throwable $e) {
            // ValidationException code 422
            $this->assertTrue($e->status === 422);
        }
    }

    /**
     * Провал валидации не совпадает подтвеждение пароля
     */
    public function testRegisterValidationPasswordWrongConfirmation()
    {
        try {
            $result = $this->controller()->register($this->request($this->registerData([
                'password_confirmation' => 'wrong-password',
            ])));
        } catch (\Throwable $e) {
            // ValidationException code 422
            $this->assertTrue($e->status === 422);
        }
    }

    /**
     * Провал валидации без g-recaptcha-response ключа
     */
    public function testRegisterValidationRecaptcha()
    {
        try {
            $result = $this->controller()->register($this->request($this->registerData()));
            $this->assertTrue($result->getStatusCode() === 422);
        } catch (\Throwable $e) {
            $this->assertTrue(false);
        }
    }

    /**
     * Успешная регистрация
     */
    public function testRegisterSuccess()
    {
        try {
            $result = $this->controller()->register($this->request($this->registerData([
                'g-recaptcha-response' => config('googlerecaptchav3.except_value'),
            ])));
            $this->assertTrue(!Auth::guest());
            $this->assertTrue($result['success']);
            $this->assertTrue($result['redirect'] === $this->controller()->redirectPath());
        } catch (\Throwable $e) {
            // ValidationException code 422
            $this->assertTrue($e->status === 422);
        }
    }

    /**
     * Корректная валидация
     *
     * @param $data
     * @return array
     */
    private function registerData(array $data = [])
    {
        $oUser = $this->factoryMake(User::class, [
            'password' => Hash::make('1234567890'),
        ]);

        return array_merge([
            'name' => $oUser->name,
            'last_name' => $oUser->name,
            'email' => $oUser->email,
            'password' => '1234567890',
            'password_confirmation' => '1234567890',
            'phone' => $oUser->phone,
        ], $data);
    }
}
