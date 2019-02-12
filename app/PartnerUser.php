<?php

namespace App;

use App\Traits\ActiveField;
use Illuminate\Database\Eloquent\Model;

class PartnerUser extends Model
{
    use ActiveField;

    protected $fillable = [
        'user_id', 'active', 'partner_id', 'email'
    ];

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
        return $this->belongsToMany(Release::class, 'partner_user_release', 'p_user_id', 'release_id');
    }

    public function quotas()
    {
        return $this->belongsToMany(Quota::class, 'partner_user_quota', 'p_user_id', 'quota_id');
    }
}
