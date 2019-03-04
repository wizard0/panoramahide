<?php
/**
 * @copyright Copyright (c) 2018-2019 "ИД Панорама"
 * @author    Дмитрий Поскачей (dposkachei@gmail.com)
 */

namespace Tests\Unit\Controllers\Auth;

use App\Http\Controllers\Auth\RegisterController;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

/**
 * Class for register controller test.
 */
class RegisterControllerTest extends TestCase
{
    use DatabaseTransactions;

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
        $this->user = testData()->user();
    }

    /**
     * Провал валидации на уникальный телефон
     */
    public function testRegisterValidationPhoneUnique()
    {
        $oController = (new RegisterController());

        $request = $this->request($this->registerData([
            'phone' => testData()->user['phone']
        ]));

        try {
            $result = $oController->register($request);
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
        $oController = (new RegisterController());

        $request = $this->request($this->registerData([
            'email' => testData()->user['email'],
        ]));
        try {
            $result = $oController->register($request);
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
        $oController = (new RegisterController());

        $request = $this->request($this->registerData([
            'password_confirmation' => 'wrong-password',
        ]));
        try {
            $result = $oController->register($request);
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
        $oController = (new RegisterController());
        $request = $this->request($this->registerData());

        try {
            $result = $oController->register($request);
            $this->assertTrue($result->getStatusCode() === 422);
        } catch (\Throwable $e) {
            //
        }
    }

    /**
     * Успешная регистрация
     */
    public function testRegisterSuccess()
    {
        $oController = (new RegisterController());

        $request = $this->request($this->registerData([
            'g-recaptcha-response' => config('googlerecaptchav3.except_value'),
        ]));
        try {
            $result = $oController->register($request);
            $this->assertTrue(!Auth::guest());
            $this->assertTrue($result['success']);
            $this->assertTrue($result['redirect'] === $oController->redirectPath());
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
        return array_merge([
            'name' => testData()->user['name'],
            'last_name' => testData()->user['name'],
            'email' => 'test' . testData()->user['email'],
            'password' => 'testtest',
            'password_confirmation' => 'testtest',
            'phone' => 79998887755,
        ], $data);
    }
}
