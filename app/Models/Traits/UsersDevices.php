<?php
/*
 * Copyright (c) 2018-2019 "ИД Панорама"
 * Автор модуля: Илья Картунин (ikartunin@gmail.com)
 */

namespace App\Models\Traits;

use App\Models\Device;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


trait UsersDevices
{
    // Добавляем новое устровство пользователю
    public function createDevice()
    {
        $oDevice = Device::create(['owner_type' => (preg_match('#.*\\\\(PartnerUser)$#', __CLASS__) ? 'partner_user' : 'user')]);
        $this->devices()->save($oDevice);
        Cookie::queue('device_id', $oDevice->id, Device::ACTIVE_DAYS * 1440);
        return $oDevice;
    }

    public function devices()
    {
        // Регулярным выражением проверяем, из какого класса вызван метод трейта
        if (preg_match('#.*\\\\(PartnerUser)$#', __CLASS__, $match))
            // Для пользователей партнёров, определяем отношения через таблицу device_partner_user
            return $this->belongsToMany(Device::class, 'device_partner_user', 'user_id', 'device_id');
        else
            // Для пользователей панорамы, определяем отношения через таблицу device_user
            return $this->belongsToMany(Device::class, 'device_user', 'user_id', 'device_id');
    }
    public function resetAllDevices()
    {
        foreach ($this->getActivationDevices() as $device) {
            $device->update([
                'active' => 0,
                'activate_date' => null,
            ]);
        }
    }

    public function getOnlineDevices()
    {
        return $this->devices->reject(function ($oDevice) {
            return !$oDevice->isOnline();
        });
    }


    /**
     * Активированные устройства с исключением текущего
     *
     * @param Device|null $oSelectedDevice
     * @return mixed
     */
    public function getActivationDevices(?Device $oSelectedDevice = null): Collection
    {
        $query = $this->devices();

        if (!is_null($oSelectedDevice)) {
            $query = $query->where('id', '<>', $oSelectedDevice->id);
        }

        return $query->whereActive(true)->get();
    }

    /**
     * Онлайн устройства с исключением текущего
     *
     * @param Device|null $oSelectedDevice
     * @return bool
     */
    public function hasOnlineDevices(?Device $oSelectedDevice = null): bool
    {
        if (!is_null($oSelectedDevice)) {
            $oDevices = $this->devices->where('id', '<>', $oSelectedDevice->id);
        } else {
            $oDevices = $this->devices;
        }

        foreach ($oDevices as $oDevice) {
            if ($oDevice->isOnline()) {
                return true;
            }
        }
        return false;
    }

    // Отправляем пользователю email со сбросом всех устройств
    public function sendResetCodeToUser($new = false)
    {
        $user = Auth::user();

        if (!$user->email) {
            return false;
        }
        $code = encrypt($user->id.':'.$user->email);

        $link = route('reader.reset', [
            'code' => $code,
        ]);

        try {
            Mail::to($user->email)->send(new \App\Mail\Device('reset', $user, [
                'link' => $link
            ]));
            return true;
        } catch (\Exception $e) {
            info($e->getMessage());
            return false;
        }
    }


    /**
     * Проверка кода сброса устройств
     *
     * @param $code
     * @return bool
     */
    public function checkResetCode(string $code): bool
    {
        $user = Auth::user();

        try {
            $code = decrypt($code);
        } catch (\Exception $e) {
            // некорректный код сброса
            return false;
        }

        $code = explode(':', $code);

        if (!isset($code[0]) || !isset($code[1])) {
            return false;
        }
        if ((int)$code[0] !== $user->id || $code[1] !== $user->email) {
            return false;
        }
        return true;
    }

}
