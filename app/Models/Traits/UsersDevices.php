<?php

namespace App\Models\Traits;

use App\Models\Device;

trait UsersDevices
{
    public function devices()
    {
        // Регулярным выражением проверяем, из какого класса вызван метод трейта
        if (preg_match("#.*\\PartnerUser$#", __CLASS__))
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

}
