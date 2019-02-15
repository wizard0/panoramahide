<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Device;
use App\Models\Partner;
use App\Models\PartnerUser;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
//use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Carbon\Carbon;

class DevicesTest extends TestCase
{
    use DatabaseTransactions;

    //Тесты по девайсам юзеров партнёров
    public function testPartnerUserDevice()
    {
        $user = factory(PartnerUser::class)->create();
        $user->createDevice();
        $user->createDevice();
        $user->createDevice();
        // Проверяем, что все устройства создались
        $this->assertTrue($user->devices()->count() == 3);

        // проверяем связь устройства с юзером
        $device = $user->devices()->inRandomOrder()->first();
        $this->assertNotNull($device->user);

        // Проверка отправки кода активации
        $device->sendCodeToUser();
        $this->assertNotNull($device->activate_code);

        // Проверяем отправку юзеру без email
        $user->email = null;
        $user->save();
        $device = $user->devices()->whereActive(false)->first();
        $this->assertTrue(!$device->sendCodeToUser());

        // Проверка, не просрочено ли не активное устройство
        $this->assertTrue(!$device->checkActivation());

        // Проверка активации по коду
        $device = Device::activateByCode($device->activate_code);
        $this->assertTrue($device->isActive());

        // Проверка, не просрочено ли активное устройство
        $this->assertTrue($device->checkActivation());

        // Проверяем активацию устройства с неверным кодом
        $this->assertNull(Device::activateByCode(md5(rand(0,9999))));

        // Проверяем методы online
        $device->setOnline();
        $this->assertTrue($device->isOnline());

        // Проверка сброса активных устройств
        $user->resetAllDevices();
        $this->assertTrue($user->devices()->whereActive(true)->count() == 0);

        // Проверка просроченного устройства
        $device = $user->devices()->first();
        $device->activateDevice();
        $device->activate_date = Carbon::now()->subDays(Device::ACTIVE_DAYS*2);
        $this->assertTrue(!$device->checkActivation());
    }

    //Тесты по девайсам юзеров партала
    public function testUserDevice()
    {
        $user = factory(\App\User::class)->create();
        $user->createDevice();
        $user->createDevice();
        $user->createDevice();
        // Проверяем, что все устройства создались
        $this->assertTrue($user->devices()->count() == 3);

        // проверяем связь устройства с юзером
        $device = $user->devices()->first();
        $this->assertNotNull($device->user);

    }
}
