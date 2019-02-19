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
     * Не авторизованный пользователь
     */
    public function testIndexDeviceNull()
    {
        $user = $this->user;

        $this->actingAs($user);

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
     * Не авторизованный пользователь
     */
    public function testIndexDeviceIsset()
    {
        $user = $this->user;

        $this->actingAs($user);

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
     * Не авторизованный пользователь
     */
    public function testIndexDeviceNotIsset()
    {
        $user = $this->user;

        $this->actingAs($user);

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
     * Не авторизованный пользователь
     */
    public function testIndexDeviceMax()
    {
        $user = $this->user;

        $this->actingAs($user);

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
     * Не авторизованный пользователь
     */
    public function testIndexDeviceActivation()
    {
        $user = $this->user;

        $this->actingAs($user);

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
     * Не авторизованный пользователь
     */
    public function testIndexDeviceOnline()
    {
        $user = $this->user;

        $this->actingAs($user);

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
     * Не авторизованный пользователь
     */
    public function testIndexSuccess()
    {
        $user = $this->user;

        $this->actingAs($user);

        $oController = (new ReaderController());

        DB::transaction(function () use ($oController) {

            $oDevice = $this->user->createDevice();
            $oDevice->activateDevice();

            $request = new Request();
            $request->merge([

            ]);

            $_COOKIE['device_id'] = $oDevice->id;

            $result = $oController->index($request);

            $oDevice = $this->user->devices()->first();

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
     * Не авторизованный пользователь
     */
    public function testCodeNullDevice()
    {
        $user = $this->user;

        $this->actingAs($user);

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
     * Не авторизованный пользователь
     */
    public function testCodeWrongCode()
    {
        $user = $this->user;

        $this->actingAs($user);

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
     * Не авторизованный пользователь
     */
    public function testCodeSuccess()
    {
        $user = $this->user;

        $this->actingAs($user);

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
     * Не авторизованный пользователь
     */
    public function testOnlineNullDevice()
    {
        $user = $this->user;

        $this->actingAs($user);

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
     * Не авторизованный пользователь
     */
    public function testOnlineSetOnline()
    {
        $user = $this->user;

        $this->actingAs($user);

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

            $oDevice = $this->user->devices()->first();

            $this->assertTrue($oDevice->isOnline());

            DB::rollBack();
        });
    }

    /**
     * Не авторизованный пользователь
     */
    public function testOnlineReset()
    {
        $user = $this->user;

        $this->actingAs($user);

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
     * Не авторизованный пользователь
     */
    public function testOnlineHasOnline()
    {
        $user = $this->user;

        $this->actingAs($user);

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
     * Не авторизованный пользователь
     */
    public function testOnlineSuccess()
    {
        $user = $this->user;

        $this->actingAs($user);

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
     * Неверный код
     *
     * @return int
     */
    public function code(): int
    {
        return 100001;
    }
}
