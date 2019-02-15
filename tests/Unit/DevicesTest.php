<?php

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
class DevicesTest extends TestCase
{
    use DatabaseTransactions;

    //Тесты по девайсам юзеров партнёров
    public function testPartnerUserDevice()
    {
        self::getUserAndDevice($user, $device);

        // Проверяем, что все устройства создались
        $this->assertEquals($user->devices()->count(), 3, $this->textRed('Ошибка createDevice'));

        // проверяем связь устройства с юзером
        $device = $user->devices()->inRandomOrder()->first();
        $this->assertNotNull($device->user, $this->textRed('Ошибка связи device->user'));
    }
    public function testActivationCodeDevice()
    {
        self::getUserAndDevice($user, $device);

        // Проверка отправки кода активации
        Mail::fake();
        $device->sendCodeToUser();
        $this->assertNotNull($device->activate_code, $this->textRed('Ошибка при отправке кода для активации устройства'));

        // Проверяем отправку юзеру без email
        $user->email = null;
        $user->save();
        $device = $user->devices()->whereActive(false)->first();
        $this->assertTrue(!$device->sendCodeToUser(), $this->textRed('Ошибка при отправке кода пользователю без email'));

        // Проверка активации по коду
        $device = Device::activateByCode($device->activate_code);
        $this->assertTrue($device->isActive(), $this->textRed('Ошибка при активации устройства по коду'));

        // Проверяем активацию устройства с неверным кодом
        $this->assertNull(Device::activateByCode(md5(rand(0,9999))), $this->textRed('Ошибка при проверке активации устройства с неверным кодом'));
    }
    public function testCheckActivationDevice()
    {
        self::getUserAndDevice($user, $device);

        // Проверка, не просрочено ли не активное устройство
        $this->assertTrue(!$device->checkActivation(), $this->textRed('Ошибка при проверке активации неактивного устройства'));

        $device->activateDevice();

        // Проверка, не просрочено ли активное устройство
        $this->assertTrue($device->checkActivation(), $this->textRed('Ошибка при проверке активации активного устройства'));

        // Проверка сброса активных устройств
        $user->resetAllDevices();
        $this->assertEquals($user->devices()->whereActive(true)->count(), 0, $this->textRed('Ошибка при проверке сброса активных устройств'));

        // Проверка просроченного устройства
        $device = $user->devices()->first();
        $device->activateDevice();
        $device->activate_date = Carbon::now()->subDays(Device::ACTIVE_DAYS*2);
        $this->assertTrue(!$device->checkActivation(), $this->textRed('Ошибка при проверке активации просроченного устройства'));
    }
    public function testCheckOnlineDevice()
    {
        self::getUserAndDevice($user, $device);

        // Проверяем методы online
        $device->setOnline();
        $this->assertTrue($device->isOnline(), $this->textRed('Ошибка при проверке методов online'));
    }

    //Тесты по девайсам юзеров партала
    public function testUserDevice()
    {
        self::getUserAndDevice($user, $device, false);

        // Проверяем, что все устройства создались
        $this->assertEquals($user->devices()->count(), 3);

        // проверяем связь устройства с юзером
        $this->assertNotNull($device->user);
    }

    // Данные для тестов
    public static function getUserAndDevice(&$user, &$device, $partner_user = true)
    {
        $user = ($partner_user ? factory(PartnerUser::class)->create() : factory(\App\User::class)->create());
        $user->createDevice();
        $user->createDevice();
        $user->createDevice();
        $device = $user->devices()->inRandomOrder()->first();
    }
}
