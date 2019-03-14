<?php
/*
 * Copyright (c) 2018-2019 "ИД Панорама"
 * Автор модуля: Илья Картунин (ikartunin@gmail.com)
 */

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Collection;
use App\Models\User;

trait OrdersUsers
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFullName()
    {
        return $this->surname
            . " " . $this->name
            . " " . $this->patronymic;
    }

    public function getDeliveryAddress()
    {
        return $this->delivery_address;
    }

    public function __get($name)
    {
        return parent::__get($name) ?? parent::__get('l_' . $name);
    }
}
