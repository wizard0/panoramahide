<?php
/*
 * Copyright (c) 2018-2019 "ИД Панорама"
 * Автор модуля: Илья Картунин (ikartunin@gmail.com)
 */

namespace App\Models;

use App\Models\Traits\ActiveField;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class Device extends Model
{
    use ActiveField;

    const ONLINE_MIN  = 5;
    const ACTIVE_DAYS = 7;
    const CODE_LENGTH = 8;

    protected $fillable = [
        'owner_type', 'active', 'activate_date',
    ];

    // Проверить, не устарело ли подтверждение устройства
    public function checkActivation()
    {
        // Проверяем, активно ли устройство по последним данным
        if (!$this->isActive())
            return false;
        // Если активно, то проверям, не просрочено ли
        if ($this->activate_date >= Carbon::now()->subDays(self::ACTIVE_DAYS))
            return true;
        // Если просрочено, то устанавливаем статус активации в false
        return $this->activateDevice(false);
    }

    // Установить/отменить активацию устройства
    public function activateDevice($active = true)
    {
        if ($active)
            $this->activate_date = Carbon::now();
        $this->activate_code = null;
        $this->setActive($active);
        return $active;
    }
    // Установить активацию устройства по коду
    public static function activateByCode($code)
    {
        if ($device = self::whereActivateCode($code)->first()) {
            $device->activateDevice();
            return $device;
        }
        return null;
    }

    // В сети ли устройство
    public function isOnline()
    {
        return ($this->online_datetime >= Carbon::now()->subMinutes(self::ONLINE_MIN));
    }

    // Задать устройству статус online
    public function setOnline()
    {
        $this->online_datetime = Carbon::now();
        $this->save();
    }

    // Генерируем код для подтверждения
    public function getCode($new = false)
    {
        // Если код для активации не задан, то по умолчанию считаем что нам нужен новый
        $new = (!$this->activate_code ? true : $new);
        if ($new) {
            $this->activate_date = null;
            // Генерируем новый год
            $this->activate_code = substr(md5($this->id.time()), 0, self::CODE_LENGTH);
            // Сбрасываем активацию
            $this->setActive(false);
        }
        return $this->activate_code;
    }

    // Отправляем пользователю email с кодом
    public function sendCodeToUser($new = false)
    {
        $code = $this->getCode($new);
        $user = $this->user;
        if (!$user->email)
            return false;
        try {
            Mail::to($user->email)->send(new \App\Mail\Device('confirm', $user, [
                'code' => $code
            ]));
            return true;
        } catch (\Exception $e) {
            info($e->getMessage());
            return false;
        }
    }

    // Связь с пользователем
    public function __get($name)
    {
        switch ($name) {
            case 'user':
                return $this->users()->first();
                break;
            default:
                return parent::__get($name);
                break;
        }
    }
    public function users()
    {
        if ($this->owner_type === 'user')
            return $this->belongsToMany(\App\User::class, 'device_user', 'device_id', 'user_id');
        else
            return $this->belongsToMany(PartnerUser::class, 'device_partner_user', 'device_id', 'user_id');
    }
}
