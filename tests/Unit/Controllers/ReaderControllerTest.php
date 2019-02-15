<?php

namespace Tests\Unit\Controllers;


use App\Http\Controllers\PromoController;
use App\Http\Controllers\ReaderController;
use App\Models\Promocode;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ReaderControllerTest extends TestCase
{
    /**
     * Не авторизованный пользователь
     */
    public function testIndexGuest()
    {
        $oController = (new ReaderController());

        $request = new Request();
        $request->merge([

        ]);

        $result = $oController->index($request);

        $this->assertTrue(session()->has('modal'));

        $this->assertTrue(session()->get('modal') === 'login-modal');
    }

    /**
     * Устройство не активировано
     */
    public function testIndexCodeAt()
    {
        $user = $this->user();

        $this->actingAs($user);

        $oController = (new ReaderController());

        DB::transaction(function () use ($user, $oController) {

            $oDevice = $user->devices()->first();

            $oDevice->update([
                'code_at' => null
            ]);

            $request = new Request();
            $request->merge([

            ]);

            $result = $oController->index($request);

            $this->assertTrue(session()->has('modal'));

            $this->assertTrue(session()->get('modal') === 'reader-code-modal');

            DB::rollBack();
        });
    }

    /**
     * Устройство просрочено
     */
    public function testIndexExpiresAt()
    {
        $user = $this->user();

        $this->actingAs($user);

        $oController = (new ReaderController());

        DB::transaction(function () use ($user, $oController) {

            $oDevice = $user->devices()->first();

            $oDevice->update([
                'code_at' => now(),
                'expires_at' => now()->subDay(),
            ]);

            $request = new Request();
            $request->merge([

            ]);

            $result = $oController->index($request);

            $this->assertTrue(session()->has('modal'));

            $this->assertTrue(session()->get('modal') === 'reader-code-modal');

            DB::rollBack();
        });
    }

    /**
     * Успешная проверка устройства и переход в читалку с данными
     */
    public function testIndexSuccess()
    {
        $user = $this->user();

        $this->actingAs($user);

        $oController = (new ReaderController());

        DB::transaction(function () use ($user, $oController) {

            $oDevice = $user->devices()->first();

            $oDevice->update([
                'code_at' => now()->subDay(),
                'expires_at' => now()->addDay(),
                'status' => 2,
            ]);

            $request = new Request();
            $request->merge([

            ]);

            $result = $oController->index($request);

            $this->assertNotNull($result->getData()['oRelease']);

            DB::rollBack();
        });
    }

    /**
     * Проверка с неправильным кодом подтверждения
     */
    public function testCodeError()
    {
        $user = $this->user();

        $this->actingAs($user);

        DB::transaction(function () {

            $oController = (new ReaderController());

            $request = new Request();
            $request->merge([
                'code' => $this->code(), // несуществующий промокод
            ]);

            $result = $oController->code($request);

            $this->assertFalse($result->getData()->success);

            DB::rollBack();
        });
    }

    /**
     * Проверка с правильным кодом подтверждения
     */
    public function testCodeSuccess()
    {
        $user = $this->user();

        $this->actingAs($user);

        DB::transaction(function () {

            $oController = (new ReaderController());

            $request = new Request();
            $request->merge([
                'code' => testData()->userDevice['code']
            ]);

            $result = $oController->code($request);

            $this->assertTrue($result['success']);

            DB::rollBack();
        });
    }

    /**
     * Тестовый пользователь
     *
     * @return mixed
     */
    private function user(): User
    {
        return testData()->user();
    }

    /**
     * Неверный код
     *
     * @return int
     */
    public function code(): int
    {
        return 100001;
    }
}
