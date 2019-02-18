<?php

namespace App\Services;

use App\Mail\Device;
use App\Models\UserDevice;
use App\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Jenssegers\Agent\Agent;

class DeviceService
{
    use Messageable;

    /**
     * @var Agent|null
     */
    private $agent = null;

    /**
     * @var User
     */
    private $user = null;

    /**
     * Ключ для хранилища названия устройства
     *
     * @var string
     */
    private $storeKey = 'device';

    /**
     * Время хранения устройства
     *
     * @var int
     */
    private $storeMinutes = 10080; // 1 неделя в минутах

    /**
     * @var int
     */
    private $onlineMinutes = 5;

    /**
     * @var int
     */
    private $maxDevices = 2;

    /**
     * DeviceService constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->agent = new Agent();
        $this->user = $user;
    }

    /**
     * @return string
     */
    private function getDevicePlatformBrowser(): ?string
    {
        $key = $this->salt();

        $name = '';

        $device = $this->getAgentValue('device');
        $browser = $this->getAgentValue('browser');
        $platform = $this->getAgentValue('platform');
        if (empty($platform) && empty($device) && empty($browser)) {
            return null;
        }
        if (!empty($platform)) {
            $name .= $platform . ':';
        }
        if (!empty($device)) {
            $name .= $device . ':';
        }
        if (!empty($browser)) {
            $name .= $browser;
        }
        return $this->nameDevice($key, $name);
    }

    /**
     * Конечное имя истройства
     *
     * @param $salt
     * @param $name
     * @return mixed
     */
    private function nameDevice(string $salt, ?string $name): ?string
    {
        return $name;
        //return $salt . ':' . $name;
    }

    /**
     * Назначить устройство
     *
     * @param string $agent
     * @return DeviceService
     */
    public function setAgent(string $agent): DeviceService
    {
        $this->agent->setUserAgent($agent);

        return $this;
    }

    /**
     * @param $name
     * @param bool $withVersion
     * @return array|null
     */
    private function getAgentValue(string $name, bool $withVersion = false)
    {
        switch ($name) {
            case 'device':
                return $this->getAgentValueVersion($this->agent->device(), $withVersion);
            case 'browser':
                return $this->getAgentValueVersion($this->agent->browser(), $withVersion);
            case 'platform':
                return $this->getAgentValueVersion($this->agent->platform(), $withVersion);
            default:
                return null;
        }
    }

    /**
     * @param string $value
     * @param bool $withVersion
     * @return array|string
     */
    private function getAgentValueVersion(string $value, bool $withVersion = false)
    {
        return $withVersion ? [
            'name' => $value,
            'version' => $this->agent->version($value),
        ] : $value;
    }

    /**
     * @return string
     */
    public function getUserDevice(): ?string
    {
        //return $this->getDevicePlatformBrowser();
        if (!$this->has()) {
            $this->set($this->getDevicePlatformBrowser());
        }
        return $this->get();
    }

    /**
     * @return bool
     */
    public function has(): bool
    {
        return Session::has($this->storeKey);
    }

    /**
     * @return string
     */
    public function get(): ?string
    {
        return Session::get($this->storeKey);
    }

    /**
     * @param $value
     */
    public function set(?string $value): void
    {
        Session::put($this->storeKey, $value);
    }

    /**
     *
     */
    public function forget(): void
    {
        Session::forget($this->storeKey);
    }

    /**
     * @return bool
     */
    public function setOnline(): bool
    {
        $device = $this->getDevice();

        if (is_null($device)) {
            return false;
        }

        $oDevices = $this->getAll();

        foreach ($oDevices as $oDevice) {
            $oDevice->update([
                'is_online' => $oDevice->id === $device->id ? 1 : 0,
            ]);
        }
        $device->update([
            'is_online_at' => now(),
        ]);

        return true;
    }

    /**
     * Проверка текущего устройства на онлайн
     *
     * @return bool
     */
    public function checkOnline()
    {
        $device = $this->getDevice();

        if ($this->checkOnlineDevice($device)) {
            return true;
        }

        return false;
    }

    /**
     * @return mixed|null
     */
    public function getOnlineDevice()
    {
        $oDevices = $this->getDevices();

        $device = null;
        foreach ($oDevices as $oDevice) {
            if ($this->checkOnlineDevice($oDevice)) {
                $device = $oDevice;
            }
        }

        if (is_null($device)) {
            return $this->getDevice();
        }

        return null;
    }

    /**
     * @return bool
     */
    public function hasOnline(): bool
    {
        $oDevices = $this->getAll();

        foreach ($oDevices as $oDevice) {
            if ($this->checkOnlineDevice($oDevice)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Проверка устройства на онлайн, по значению is_online и is_online_at должен быть не больше 5 минут
     *
     * @param UserDevice $oDevice
     * @return bool
     */
    private function checkOnlineDevice(UserDevice $oDevice): bool
    {
        return $oDevice->is_online === 1 && now()->diffInMinutes($oDevice->is_online_at) < $this->onlineMinutes;
    }

    /**
     *
     */
    public function sendEmailConfirmDevice(): void
    {
        $device = $this->getDevice();

        Mail::to($this->user)->send(new Device('confirm', $this->user, $device));
    }

    /**
     *
     */
    public function sendEmailResetDevice(): void
    {
        Mail::to($this->user)->send(new Device('reset', $this->user));
    }

    /**
     * @return bool
     */
    public function clear(): bool
    {
        if ($this->has()) {
            $this->forget();
            return true;
        }
        return false;
    }

    /**
     * @return string
     */
    public function getStoreKey(): string
    {
        return $this->storeKey;
    }


    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->user->devices;
    }

    /**
     * @return UserDevice
     */
    public function createDevice(): UserDevice
    {
        return UserDevice::create([
            'user_id' => $this->user->id,
            'code' => $this->getCode(),
            'name' => $this->getUserDevice(),
            'expires_at' => now()->addMinutes($this->storeMinutes),
            'status' => 1,
        ]);
    }

    /**
     * @return bool
     */
    public function activateDevice(): bool
    {
        $device = $this->getDevice();

        if (is_null($device)) {
            return false;
        }
        $device->update([
            'code_at' => now(),
            'expires_at' => now()->addMinutes($this->storeMinutes),
            'status' => 2,
        ]);
        return true;
    }

    /**
     * @param $code
     * @return bool
     */
    public function checkCode(int $code): bool
    {
        $device = $this->getDevice();

        if ($device->code !== $code) {
            $this->setMessage('Устройство не найдено');
            return false;
        }

        $this->activateDevice();
        return true;
    }

    /**
     * @return bool
     */
    public function hasDevice(): bool
    {
        return is_null($this->getDevice());
    }

    /**
     * @return UserDevice
     */
    public function getDevice(): UserDevice
    {
        $device = $this->getCurrentDevice();

        if (is_null($device)) {
            $device = $this->createDevice();
        }

        return $device;
    }

    /**
     * @return bool
     */
    public function canCreate()
    {
        $devices = $this->getDevices();

        if (count($devices) >= $this->maxDevices) {
            $this->setMessage('Достигнуто максимально количество разрешенных устройств.');
            return false;
        }
        return true;
    }

    /**
     * @return UserDevice
     */
    public function getCurrentDevice(): ?UserDevice
    {
        $nameDevice = $this->getUserDevice();

        $devices = $this->user->devices();

        // возможно только во время тестов
        if (!is_null($nameDevice)) {
            $devices = $devices->where('name', $nameDevice);
        }

        $device = $devices->first();

        return $device;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getDevices(): \Illuminate\Database\Eloquent\Collection
    {
        $nameDevice = $this->getUserDevice();

        $devices = $this->user->devices();

        if (!is_null($nameDevice)) {
            $devices = $devices->where('name', '<>', $nameDevice);
        }
        $devices = $devices->get();

        return $devices;
    }

    /**
     * @param UserDevice $device
     * @return bool
     */
    public function checkDevice(UserDevice $device): bool
    {
        if ($device->status === 1) {
            $this->setMessage('Устройство не подтверждено');
            return false;
        }

        if ($device->status === 3) {
            $this->setMessage('Устройства устарело');
            return false;
        }

        if ($device->expires_at < now()) {
            $device->update([
                'status' => 3,
            ]);
            $this->setMessage('Устройства устарело');
            return false;
        }
        return true;
    }

    /**
     * @return string
     */
    private function salt(): string
    {
        return Hash::make($this->user->id . '' . $this->user->email);
    }

    /**
     * @return int
     */
    private function getCode(): int
    {
        return mt_rand(100000, 999999);
    }
}
