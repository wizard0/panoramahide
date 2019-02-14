<?php

namespace Tests\Unit\Services;

use App\Release;
use App\Services\DeviceService;
use App\Services\ReaderService;
use App\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DeviceServiceTest extends TestCase
{
    /**
     * Пример использования
     */
    public function example()
    {

    }

    /**
     * Тестирование сессии устройства
     */
    public function testSession()
    {
        $user = $this->user();

        $this->actingAs($user);

        $oDeviceService = new DeviceService($user);

        // авторизация

        $oDeviceService->setAgent($this->agent());

        $data[$oDeviceService->getStoreKey()] = $oDeviceService->getUserDevice();

        $this->withSession($data);

        $this->assertAuthenticated();

        $this->assertTrue($oDeviceService->getUserDevice() === $data[$oDeviceService->getStoreKey()]);
    }

    /**
     * Тест сохранение в сессиию устройства
     */
    public function testSetSession()
    {
        $user = $this->user();

        $this->actingAs($user);

        $oDeviceService = new DeviceService($user);

        $oDeviceService->setAgent($this->agent());

        $data[$oDeviceService->getStoreKey()] = $oDeviceService->getUserDevice();

        $oDeviceService->set($oDeviceService->getUserDevice());

        $this->assertTrue($oDeviceService->has());

        $this->assertNotNull($oDeviceService->get());
    }

    /**
     * Тест удаление из сессии
     */
    public function testForgetSession()
    {
        $user = $this->user();

        $this->actingAs($user);

        $oDeviceService = new DeviceService($user);

        $oDeviceService->setAgent($this->agent());

        $data[$oDeviceService->getStoreKey()] = $oDeviceService->getUserDevice();

        $oDeviceService->set($oDeviceService->getUserDevice());

        $this->assertTrue($oDeviceService->has());

        $oDeviceService->forget();

        $this->assertFalse($oDeviceService->has());

        $this->assertNull($oDeviceService->get());
    }


    public function testSaveDevice()
    {
        $user = $this->user();

        $this->actingAs($user);

        $oDeviceService = new DeviceService($user);

        $oDeviceService->setAgent($this->agent());


        DB::transaction(function () use ($oDeviceService) {

            $oDeviceService->createDevice();

            $this->assertNotNull($oDeviceService->getDevice());

            DB::rollBack();
        });

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

    /**
     * Тестовый пользователь
     *
     * @return mixed
     */
    private function user(): User
    {
        return testData()->user();
    }
}
