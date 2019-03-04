<?php
/**
 * @copyright Copyright (c) 2018-2019 "ИД Панорама"
 * @author    Илья Картунин (ikartunin@gmail.com)
 */

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Device;
use App\Models\Partner;
use App\Models\PartnerUser;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Carbon\Carbon;
use Mail;

/**
 * Class for devices test.
 */
class DevicesTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;
    protected $device;

    protected function setUp()
    {
        parent::setUp();
        $this->getUserAndDevice();
    }

    protected function tearDown()
    {
        unset($this->user);
        unset($this->device);
    }

    protected function getUserAndDevice($partner_user = true)
    {
        $this->user = ($partner_user ? factory(PartnerUser::class)->create() : factory(\App\User::class)->create());
        $this->user->createDevice();
        $this->user->createDevice();
        $this->user->createDevice();
        $this->device = $this->user->devices()->inRandomOrder()->first();
    }

    /**
     * Тесты по девайсам юзеров партала
     */
    public function testUserDevice()
    {
        $this->getUserAndDevice(false);
        // Проверяем, что все устройства создались
        $this->assertEquals($this->user->devices()->count(), 3);
        // проверяем связь устройства с юзером
        $this->assertNotNull($this->device->user);
    }

    /**
     * Тесты по девайсам юзеров партнёров
     */
    public function testPartnerUserDevice()
    {
        // Проверяем, что все устройства создались
        $this->assertEquals($this->user->devices()->count(), 3, $this->textRed('Ошибка createDevice'));
        // проверяем связь устройства с юзером
        $device = $this->user->devices()->inRandomOrder()->first();
        $this->assertNotNull($device->user, $this->textRed('Ошибка связи device->user'));
    }

    public function testSendCodeToUser()
    {
        // Проверка отправки кода активации
        Mail::fake();
        $this->device->sendCodeToUser();
        $this->assertNotNull($this->device->activate_code, $this->textRed('Ошибка при отправке кода для активации устройства'));

        // Проверяем отправку юзеру без email
        $this->user->email = null;
        $this->user->save();
        $device = $this->user->devices()->whereActive(false)->first();
        $this->assertTrue(!$device->sendCodeToUser(), $this->textRed('Ошибка при отправке кода пользователю без email'));
    }

    public function testDeviceActivationByCode()
    {
        $this->device->getCode();

        // Проверяем активацию устройства с неверным кодом
        $this->assertNull(Device::activateByCode(md5(rand(0, 9999))), $this->textRed('Ошибка при проверке активации устройства с неверным кодом'));

        // Проверка активации по коду
        $device = Device::activateByCode($this->device->activate_code);
        $this->assertTrue($device->isActive(), $this->textRed('Ошибка при активации устройства по коду'));
    }

    public function testCheckActivationDevice()
    {
        // Проверка, не просрочено ли не активное устройство
        $this->assertTrue(!$this->device->checkActivation(), $this->textRed('Ошибка при проверке активации неактивного устройства'));

        // Проверка, не просрочено ли активное устройство
        $this->device->activateDevice();
        $this->assertTrue($this->device->checkActivation(), $this->textRed('Ошибка при проверке активации активного устройства'));

        // Проверка просроченного устройства
        $device = $this->user->devices()->first();
        $device->activateDevice();
        $device->activate_date = Carbon::now()->subDays(Device::ACTIVE_DAYS * 2);
        $this->assertTrue(!$device->checkActivation(), $this->textRed('Ошибка при проверке активации просроченного устройства'));
    }

    public function testResetAllDevices()
    {
        foreach ($this->user->devices as $device) {
            $device->activateDevice();
        }
        // Проверка сброса активных устройств
        $this->user->resetAllDevices();
        $this->assertEquals($this->user->devices()->whereActive(true)->count(), 0, $this->textRed('Ошибка при проверке сброса активных устройств'));
    }

    public function testCheckOnlineDevice()
    {
        // Проверяем методы online
        $this->device->setOnline();
        $this->assertTrue($this->device->isOnline(), $this->textRed('Ошибка при проверке методов online'));
    }
}
