<?php
/*
 * Copyright (c) 2018-2019 "ИД Панорама"
 * Автор модуля: Илья Картунин (ikartunin@gmail.com)
 */

namespace App\Models\Traits;

use App\Models\Device;

trait UsersDevices
{
    // Добавляем новое устровство пользователю
    public function createDevice()
    {
        $oDevice = Device::create(['owner_type' => (preg_match('#.*\\\\(PartnerUser)$#', __CLASS__) ? 'partner_user' : 'user')]);
        $this->devices()->save($oDevice);
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
        foreach ($this->devices()->whereActive(true)->get() as $device) {
            $device->activateDevice(false);
        }
    }

    public function getOnlineDevices()
    {
        return $this->devices->reject(function ($oDevice) {
            return !$oDevice->isOnline();
        });
    }

    /**
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

}
