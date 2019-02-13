<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Device;
use App\Models\PartnerUser;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Carbon\Carbon;

class DevicesTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    //Тесты по девайсам юзеров партнёров
    public function testPartnerUserCreateDevice()
    {
        $result = true;
        for ($i=0; $i < 100; $i++) {
            $user = PartnerUser::inRandomOrder()->first();
            $user->createDevice();
            if ($user->devices()->count() == 0)
                $result = false;
        }
        $this->assertTrue($result);
    }
    public function testGetDeviceUser()
    {
        $result = true;
        for ($i=0; $i < 100; $i++) {
            $device = Device::inRandomOrder()->first();
            if ($device->user == null)
                $result = false;
        }
        $this->assertTrue($result);
    }
    public function testGetUserDevices()
    {
        $result = true;
        for ($i=0; $i < 100; $i++) {
            $user = PartnerUser::inRandomOrder()->first();
            if ($user->devices == null)
                $result = false;
        }
        $this->assertTrue($result);
    }
    public function testDeviceActivateByCode()
    {
        $result = true;
        for ($i=0; $i < 50; $i++) {
            $device = Device::inRandomOrder()->first();
            $device->sendCodeToUser();
            if ($device->activate_code == null)
                $result = false;
            $device = Device::whereNotNull('activate_code')->first();
            $device = Device::activateByCode($device->activate_code);
            if ($device->isActive() == false)
                $result = false;
        }
        $this->assertTrue($result);
    }
    public function testResetUserDevices()
    {
        for ($i=0; $i < 50; $i++) {
            $user = null;
            do {
                $user = PartnerUser::inRandomOrder()->first();
            } while ($user->devices()->count() == 0);
            if ($user->devices()->count() > $user->devices()->whereActive(true)->count()) {
                foreach ($user->devices()->get() as $device)
                    $device->activateDevice();
                if ($user->devices()->count() != $user->devices()->whereActive(true)->count())
                    return $this->assertTrue(false);
            }
            $user->resetAllDevices();
            if ($user->devices()->whereActive(true)->count() != 0)
                return $this->assertTrue(false);
        }
        return $this->assertTrue(true);
    }
    public function testActivateDevices()
    {
        $activeCount = Device::whereActive(true)->count();
        foreach (Device::whereActive(false)->get() as $device) {
            if (rand(0,1)) {
                $activeCount++;
                $device->activateDevice();
            }
        }
        $this->assertTrue($activeCount == Device::whereActive(true)->count());
    }
    public function testOnlineDevices()
    {
        foreach (Device::whereActive(true)->get() as $device) {
            if (rand(0,1) && !$device->isOnline()) {
                $device->setOnline();
                if (!$device->isOnline())
                    return $this->assertTrue(false);
            }
        }
        $this->assertTrue(true);
    }
}
