<?php

namespace Tests\Unit\Controllers;


use App\Http\Controllers\PromoController;
use App\Http\Controllers\ReaderController;
use App\Models\Promocode;
use App\Models\UserDevice;
use App\Services\DeviceService;
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
     * Другое устройство онлайн
     */
    public function testIndexHasOnline()
    {
        $user = $this->user();

        $this->actingAs($user);

        $oController = (new ReaderController());

        DB::transaction(function () use ($user, $oController) {

            $oFirstDevice = $user->devices()->first();

            $oDevices = $user->devices;

            $oDevice = $oDevices->reject(function ($item) use ($oFirstDevice) {
                return $item->id === $oFirstDevice->id;
            })->first();

            $oFirstDevice->update([
                'is_online' => 0,
                'is_online_at' => now()->addMinute(2),
                'code_at' => now()->subDay(),
                'expires_at' => now()->addDay(),
                'status' => 2,
            ]);

            $oDevice->update([
                'is_online' => 1,
                'is_online_at' => now()->addMinute(2),
                'code_at' => now()->subDay(),
                'expires_at' => now()->addDay(),
                'status' => 2,
            ]);

            $request = new Request();
            $request->merge([

            ]);

            $result = $oController->index($request);

            $this->assertTrue(session()->has('modal'));

            $this->assertTrue(session()->get('modal') === 'reader-confirm-online-modal');

            DB::rollBack();
        });
    }

    /**
     * Другое устройство онлайн, новое создать нельзя
     */
    public function testIndexCantCreate()
    {
        $user = $this->user();

        $this->actingAs($user);

        $oController = (new ReaderController());


        DB::transaction(function () use ($user, $oController) {

            $oDevices = $user->devices()->get();

            $request = new Request();
            $request->merge([
                'agent' => $this->agent()
            ]);

            $result = $oController->index($request);

            $oDevices = $user->devices()->get();

            $this->assertTrue(session()->has('modal'));

            $this->assertTrue(session()->get('modal') === 'reader-max-devices-modal');

            DB::rollBack();
        });
    }

    /**
     * Другое устройство онлайн
     */
    public function testIndexCantCreateException()
    {
        $user = $this->user();

        $this->actingAs($user);

        $oController = (new ReaderController());

        DB::transaction(function () use ($user, $oController) {

            $oDevices = $user->devices()->get();

            foreach ($oDevices as $oDevice) {
                $oDevice->delete();
            }

            $request = new Request();
            $request->merge([

            ]);

            $result = $oController->index($request);

            $this->assertTrue(session()->has('toastr::notifications'));

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
                'is_online' => 0,
            ]);

            $oDevice->update([
                'code_at' => now()->subDay(),
                'expires_at' => now()->addDay(),
                'status' => 2,
            ]);

            $request = new Request();
            $request->merge([

            ]);

            $result = $oController->index($request);

            $oDevice = $user->devices()->first();

            $this->assertTrue($oDevice->is_online === 1);

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
     * Выпуск
     */
    public function testRelease()
    {
        $oController = (new ReaderController());

        $request = new Request();
        $request->merge([

        ]);

        $result = $oController->release($request);

        $this->assertTrue(!empty($result['data']));
    }

    /**
     * Выпуски
     */
    public function testReleases()
    {
        $oController = (new ReaderController());

        $request = new Request();
        $request->merge([

        ]);

        $result = $oController->releases($request);

        $this->assertTrue(!empty($result['data']));
    }

    /**
     * Статьи
     */
    public function testArticles()
    {
        $oController = (new ReaderController());

        $request = new Request();
        $request->merge([

        ]);

        $result = $oController->articles($request);

        $this->assertTrue(!empty($result['data']));
    }

    /**
     * Запрос на сброс устройств
     */
    public function testOnlineReset()
    {
        $user = $this->user();

        $this->actingAs($user);

        $oController = (new ReaderController());

        $request = new Request();
        $request->merge([
            'reset' => 1
        ]);

        $result = $oController->online($request);

        $this->assertTrue($result['result'] === 5);
    }

    /**
     * Сообщение устройство уже онлайн
     */
    public function testOnlineLock()
    {
        $user = $this->user();

        $this->actingAs($user);

        $oController = (new ReaderController());

        DB::transaction(function () use ($user, $oController) {

            $oFirstDevice = $user->devices()->first();

            $oDevices = $user->devices;

            $oDevice = $oDevices->reject(function ($item) use ($oFirstDevice) {
                return $item->id === $oFirstDevice->id;
            })->first();

            $oFirstDevice->update([
                'is_online' => 0,
                'is_online_at' => now()->addMinute(2),
                'code_at' => now()->subDay(),
                'expires_at' => now()->addDay(),
                'status' => 2,
            ]);

            $oDevice->update([
                'is_online' => 1,
                'is_online_at' => now()->addMinute(2),
                'code_at' => now()->subDay(),
                'expires_at' => now()->addDay(),
                'status' => 2,
            ]);

            $request = new Request();
            $request->merge([

            ]);

            $result = $oController->online($request);

            $this->assertFalse($result['success']);

            $this->assertTrue(isset($result['toastr']));

            DB::rollBack();
        });
    }

    /**
     * Тестирование назначить устройство онлайн
     */
    public function testOnlineSetOnline()
    {
        $user = $this->user();

        $this->actingAs($user);

        $oController = (new ReaderController());

        DB::transaction(function () use ($oController) {

            $request = new Request();
            $request->merge([
                'online' => 1
            ]);

            $result = $oController->online($request);

            $this->assertTrue($result['result'] === 4);

            DB::rollBack();
        });
    }

    /**
     * Без какого либо исхода
     */
    public function testOnlineEmpty()
    {
        $user = $this->user();

        $this->actingAs($user);

        $oController = (new ReaderController());

        DB::transaction(function () use ($user, $oController) {

            $oFirstDevice = $user->devices()->first();

            $oDevices = $user->devices;

            $oDevice = $oDevices->reject(function ($item) use ($oFirstDevice) {
                return $item->id === $oFirstDevice->id;
            })->first();

            $oFirstDevice->update([
                'is_online' => 1,
                'is_online_at' => now()->addMinute(2),
                'code_at' => now()->subDay(),
                'expires_at' => now()->addDay(),
                'status' => 2,
            ]);

            $oDevice->update([
                'is_online' => 0,
                'is_online_at' => now()->addMinute(2),
                'code_at' => now()->subDay(),
                'expires_at' => now()->addDay(),
                'status' => 2,
            ]);

            $request = new Request();
            $request->merge([

            ]);

            $result = $oController->online($request);

            $this->assertTrue($result['success']);

            $this->assertTrue(!isset($result['toastr']));

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

    /**
     * Тестовое устройство
     *
     * @return string
     */
    private function agent(): string
    {
        return 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/537.13+ (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2';
    }
}
