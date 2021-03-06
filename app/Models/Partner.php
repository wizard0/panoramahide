<?php
/*
 * Copyright (c) 2018-2019 "ИД Панорама"
 * Автор модуля: Илья Картунин (ikartunin@gmail.com)
 */

namespace App\Models;

use App\Models\Traits\ActiveField;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use ActiveField;

    protected $fillable = [
        'secret_key', 'active'
    ];

    public function users()
    {
        return $this->hasMany(PartnerUser::class);
    }
    public function quotas()
    {
        return $this->hasMany(Quota::class);
    }
}
