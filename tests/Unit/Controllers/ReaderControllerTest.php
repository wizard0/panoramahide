<?php

namespace Tests\Unit\Controllers;


use App\Http\Controllers\PromoController;
use App\Http\Controllers\ReaderController;
use App\Models\Device;
use App\Models\Promocode;
use App\Services\DeviceService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ReaderControllerTest extends TestCase
{
    /**
     * @var User
     */
    private $user;

    /**
     *
     */
    protected function setUp()
    {
        parent::setUp();
        $this->setUserAndDevice();
    }

    /**
     * Созд
     */
    public function setUserAndDevice()
    {
        $this->user = $this->user();
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
     * Проверка обработки сессии на не успешный сброс устройств
     */
    public function testIndexResetWrong()
    {
        $this->actingAs($this->user);

        $oController = (new ReaderController());

        DB::transaction(function () use ($oController) {

            $request = new Request();
            $request->merge([

            ]);

            session()->put('reset-wrong', 1);

            $result = $oController->index($request);

            $this->assertTrue(session()->has('modal'));

            DB::rollBack();
        });
    }

    /**
     * Проверка обработки сессии на успешный сброс устройств
     */
    public function testIndexResetSuccess()
    {
        $this->actingAs($this->user);

        $oController = (new ReaderController());

        DB::transaction(function () use ($oController) {

            $request = new Request();
            $request->merge([

            ]);

            session()->put('reset-success', 1);

            $result = $oController->index($request);

            $this->assertTrue(!session()->has('reset-success'));

            DB::rollBack();
        });
    }

    /**
     * Не авторизованный пользователь
     */
    public function testIndexGuest()
    {
        $oController = (new ReaderController());

        DB::transaction(function () use ($oController) {

            //$this->user->createDevice();
            //$this->user->createDevice();

            $request = new Request();
            $request->merge([

            ]);

            $result = $oController->index($request);

            $this->assertTrue(session()->has('modal'));

            $this->assertTrue(session()->get('modal') === 'login-modal');

            DB::rollBack();
        });
    }

    /**
     * Читалка. Устройство не найдено
     */
    public function testIndexDeviceNull()
    {
        $this->actingAs($this->user);

        $oController = (new ReaderController());

        DB::transaction(function () use ($oController) {

            $countBefore = $this->user->devices()->count();

            $request = new Request();
            $request->merge([

            ]);

            $result = $oController->index($request);

            $countAfter = $this->user->devices()->count();

            $this->assertTrue($countAfter > $countBefore);

            DB::rollBack();
        });
    }

    /**
     * Читалка. Устройство найдено по id
     */
    public function testIndexDeviceIsset()
    {
        $this->actingAs($this->user);

        $oController = (new ReaderController());

        DB::transaction(function () use ($oController) {

            $oDevice = $this->user->createDevice();

            $countBefore = $this->user->devices()->count();


            $request = new Request();
            $request->merge([

            ]);

            $_COOKIE['device_id'] = $oDevice->id;

            $result = $oController->index($request);

            $countAfter = $this->user->devices()->count();

            $this->assertTrue($countAfter === $countBefore);

            DB::rollBack();
        });
    }

    /**
     * Читалка. Устройство не сущенствует по id
     */
    public function testIndexDeviceNotIsset()
    {
        $this->actingAs($this->user);

        $oController = (new ReaderController());

        DB::transaction(function () use ($oController) {

            $oDevice = $this->user->createDevice();

            $countBefore = $this->user->devices()->count();


            $request = new Request();
            $request->merge([

            ]);

            $_COOKIE['device_id'] = Device::orderBy('id', 'desc')->first()->id + 1;

            $result = $oController->index($request);

            $countAfter = $this->user->devices()->count();

            $this->assertTrue($countAfter > $countBefore);

            DB::rollBack();
        });
    }

    /**
     * Читалка. Максимальное количество устройств
     */
    public function testIndexDeviceMax()
    {
        $this->actingAs($this->user);

        $oController = (new ReaderController());

        DB::transaction(function () use ($oController) {

            $oDevice = $this->user->createDevice();
            $oDevice->activateDevice();
            $oDevice = $this->user->createDevice();
            $oDevice->activateDevice();

            $countBefore = $this->user->devices()->count();


            $request = new Request();
            $request->merge([

            ]);

            $_COOKIE['device_id'] = null;

            $result = $oController->index($request);

            $countAfter = $this->user->devices()->count();

            $this->assertTrue($countAfter > $countBefore);

            $this->assertTrue(session()->has('modal'));

            $this->assertTrue(session()->get('modal') === 'reader-max-devices-modal');

            DB::rollBack();
        });
    }

    /**
     * Читалка. Подтвержите устройство
     */
    public function testIndexDeviceActivation()
    {
        $this->actingAs($this->user);

        $oController = (new ReaderController());

        DB::transaction(function () use ($oController) {

            $oDevice = $this->user->createDevice();

            $countBefore = $this->user->devices()->count();


            $request = new Request();
            $request->merge([

            ]);

            $_COOKIE['device_id'] = null;

            $result = $oController->index($request);

            $countAfter = $this->user->devices()->count();

            $this->assertTrue($countAfter > $countBefore);

            $this->assertTrue(session()->has('modal'));

            $this->assertTrue(session()->get('modal') === 'reader-code-modal');

            DB::rollBack();
        });
    }

    /**
     * Читалка, есть устройство онлайн
     */
    public function testIndexDeviceOnline()
    {
        $this->actingAs($this->user);

        $oController = (new ReaderController());

        DB::transaction(function () use ($oController) {

            $oDevice = $this->user->createDevice();
            $oDevice->activateDevice();
            $oDevice->setOnline();

            $oDevice = $this->user->createDevice();
            $oDevice->activateDevice();

            $request = new Request();
            $request->merge([

            ]);

            $_COOKIE['device_id'] = $oDevice->id;

            $result = $oController->index($request);

            $this->assertTrue(session()->has('modal'));

            $this->assertTrue(session()->get('modal') === 'reader-confirm-online-modal');

            DB::rollBack();
        });
    }

    /**
     * Читалка открыт доступ
     */
    public function testIndexSuccess()
    {
        $this->actingAs($this->user);

        $oController = (new ReaderController());

        DB::transaction(function () use ($oController) {

            $oDevice = $this->user->createDevice();
            $oDevice->activateDevice();

            $request = new Request();
            $request->merge([
                'release_id' => 1,
            ]);

            $_COOKIE['device_id'] = $oDevice->id;

            $result = $oController->index($request);

            $oDevice = $this->user->devices()->where('id', $oDevice->id)->first();

            $this->assertTrue($oDevice->isOnline());

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
     * Подтверждение устройства, устройство не найдено
     */
    public function testCodeNullDevice()
    {
        $this->actingAs($this->user);

        $oController = (new ReaderController());

        DB::transaction(function () use ($oController) {

            $oDevice = $this->user->createDevice();
            $oDevice->sendCodeToUser();

            $request = new Request();
            $request->merge([
                'code' => $oDevice->activate_code.'00000',
            ]);

            $_COOKIE['device_id'] = null;

            $result = $oController->code($request);

            $this->assertFalse($result->getData()->success);

            DB::rollBack();
        });
    }

    /**
     * Неверный код подтверждения
     */
    public function testCodeWrongCode()
    {
        $this->actingAs($this->user);

        $oController = (new ReaderController());

        DB::transaction(function () use ($oController) {

            $oDevice = $this->user->createDevice();
            $oDevice->sendCodeToUser();

            $request = new Request();
            $request->merge([
                'code' => $oDevice->activate_code.'00000',
            ]);

            $_COOKIE['device_id'] = $oDevice->id;

            $result = $oController->code($request);

            $this->assertFalse($result->getData()->success);

            DB::rollBack();
        });
    }

    /**
     * Код подтверждения успешный
     */
    public function testCodeSuccess()
    {
        $this->actingAs($this->user);

        $oController = (new ReaderController());

        DB::transaction(function () use ($oController) {

            $oDevice = $this->user->createDevice();
            $oDevice->sendCodeToUser();

            $request = new Request();
            $request->merge([
                'code' => $oDevice->activate_code,
            ]);

            $_COOKIE['device_id'] = $oDevice->id;

            $result = $oController->code($request);

            $this->assertTrue($result['success']);

            DB::rollBack();
        });
    }

    /**
     * Проверка онлайн, устройство не найдено
     */
    public function testOnlineNullDevice()
    {
        $this->actingAs($this->user);

        $oController = (new ReaderController());

        DB::transaction(function () use ($oController) {

            $oDevice = $this->user->createDevice();
            $oDevice->activateDevice();

            $request = new Request();
            $request->merge([

            ]);

            $_COOKIE['device_id'] = null;

            $result = $oController->online($request);

            $this->assertFalse($result['success']);

            DB::rollBack();
        });
    }

    /**
     * Читать с этого устройства
     */
    public function testOnlineSetOnline()
    {
        $this->actingAs($this->user);

        $oController = (new ReaderController());

        DB::transaction(function () use ($oController) {

            $oDevice = $this->user->createDevice();
            $oDevice->activateDevice();

            $request = new Request();
            $request->merge([
                'online' => 1
            ]);

            $_COOKIE['device_id'] = $oDevice->id;

            $result = $oController->online($request);

            $oDevice = $this->user->devices()->where('id', $oDevice->id)->first();

            $this->assertTrue($oDevice->isOnline());

            DB::rollBack();
        });
    }

    /**
     * Запрос ссылки сброса устройств
     */
    public function testOnlineReset()
    {
        $this->actingAs($this->user);

        $oController = (new ReaderController());

        DB::transaction(function () use ($oController) {

            $oDevice = $this->user->createDevice();
            $oDevice->activateDevice();

            $request = new Request();
            $request->merge([
                'reset' => 1
            ]);

            $_COOKIE['device_id'] = $oDevice->id;

            $result = $oController->online($request);

            $this->assertTrue($result['result'] === 5);

            DB::rollBack();
        });
    }

    /**
     * Есть онлайн устройства
     */
    public function testOnlineHasOnline()
    {
        $this->actingAs($this->user);

        $oController = (new ReaderController());

        DB::transaction(function () use ($oController) {

            $oDevice = $this->user->createDevice();
            $oDevice->activateDevice();
            $oDevice->setOnline();

            $oDevice = $this->user->createDevice();
            $oDevice->activateDevice();

            $request = new Request();
            $request->merge([

            ]);

            $_COOKIE['device_id'] = $oDevice->id;

            $result = $oController->online($request);

            $this->assertFalse($result['success']);

            DB::rollBack();
        });
    }

    /**
     * Проверка онлайн успешна
     */
    public function testOnlineSuccess()
    {
        $this->actingAs($this->user);

        $oController = (new ReaderController());

        DB::transaction(function () use ($oController) {

            $oDevice = $this->user->createDevice();
            $oDevice->activateDevice();
            $oDevice->setOnline();

            $request = new Request();
            $request->merge([

            ]);

            $_COOKIE['device_id'] = $oDevice->id;

            $result = $oController->online($request);

            $this->assertTrue($result['success']);

            DB::rollBack();
        });
    }

    /**
     * Сброс устройств для неавторизованного пользователя
     */
    public function testResetGuest()
    {
        $oController = (new ReaderController());

        DB::transaction(function () use ($oController) {

            $request = new Request();
            $request->merge([

            ]);

            $result = $oController->reset($request, 'code');

            $this->assertTrue(session()->has('modal'));

            $this->assertTrue(session()->get('modal') === 'login-modal');

            DB::rollBack();
        });
    }

    /**
     * Не успешный сброс устройств, неверный код
     */
    public function testResetCheckError()
    {
        $this->actingAs($this->user);

        $oController = (new ReaderController());

        DB::transaction(function () use ($oController) {

            $oDevice = $this->user->createDevice();
            $oDevice->activateDevice();

            $request = new Request();
            $request->merge([

            ]);

            $result = $oController->reset($request, 'code');

            $this->assertTrue(session()->has('reset-wrong'));

            $oDevice = $this->user->devices()->where('id', $oDevice->id)->first();

            $this->assertTrue($oDevice->active === 1);

            DB::rollBack();
        });
    }

    /**
     * Успешный сброс устройств
     */
    public function testResetCheckSuccess()
    {
        $this->actingAs($this->user);

        $oController = (new ReaderController());

        DB::transaction(function () use ($oController) {

            $oDevice = $this->user->createDevice();
            $oDevice->activateDevice();

            $request = new Request();
            $request->merge([

            ]);

            $code = encrypt($this->user->id.':'.$this->user->email);

            $result = $oController->reset($request, $code);

            $this->assertTrue(session()->has('reset-success'));

            $oDevice = $this->user->devices()->first();

            $this->assertTrue($oDevice->active === 0);

            DB::rollBack();
        });
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
