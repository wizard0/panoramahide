<?php
/*
 * Copyright (c) 2018-2019 "ИД Панорама"
 * Автор модуля: Илья Картунин (ikartunin@gmail.com)
 */

namespace App\Models;

use App\Models\Traits\ActiveField;
use App\Models\Traits\UsersDevices;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;

class PartnerUser extends Model
{
    use ActiveField;
    use UsersDevices;

    const COOKIE_NAME           = 'PartnerUser';
    const COOKIE_NAME_SEPORATOR = '|@|@|';

    protected $fillable = [
        'user_id', 'active', 'partner_id', 'email'
    ];

    public static function getUserByCookie(&$User)
    {
        if (Cookie::has(self::COOKIE_NAME)) {
            // Заглушка для тестирования. Кука из тестов обростает лишними символами
            $cookie = (preg_match('#s:(\d+):"(.*)";#', Cookie::get(self::COOKIE_NAME), $match) ? $match[2] : Cookie::get(self::COOKIE_NAME));
            $cookie = explode(self::COOKIE_NAME_SEPORATOR, $cookie);
            if (count($cookie) != 2)
                return false;

            $partner_user = PartnerUser::whereUserId($cookie[1])->first();
            if ($partner_user && $partner_user->partner->id == $cookie[0]) {
                $User = $partner_user;
                return true;
            }
        }
        return false;
    }
    public function isAvailable()
    {
        // Проверяем, активен ли партнёр
        if (!$this->partner->isActive())
            return false;
        // Проверяем, активен ли текущий пользователь
        if (!$this->isActive())
            return false;
        //
        return true;
    }

    public function useQuota($quota_id)
    {
        // Если квота не назначена пользователю
        if (!$this->quotas()->find($quota_id)) {
            // Проверяем, можно ли дать квоту пользователю
            if (!$this->isAvailable())
                return false;
            // Ищем запрошенную квоту у партнёра
            $quota = $this->partner->quotas()->find($quota_id);
            // Если квота не найдена - отказ
            if (!$quota)
                return false;
            // Пытаемся использовать квоту
            if (!$quota->use())
                return false;
            // Если удалось использовать - устанавливаем отношение пользователя с квотой
            $this->quotas()->save($quota);
        }
        return true;
    }

    public function partner()
    {
        return $this->hasOne(Partner::class, 'id', 'partner_id');
    }

    public function releases()
    {
        return $this->belongsToMany(\App\Release::class, 'partner_user_release', 'p_user_id', 'release_id');
    }

    public function quotas()
    {
        return $this->belongsToMany(Quota::class, 'partner_user_quota', 'p_user_id', 'quota_id');
    }

}
