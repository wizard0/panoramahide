<?php
/*
 * Copyright (c) 2018-2019 "ИД Панорама"
 * Автор модуля: Илья Картунин (ikartunin@gmail.com)
 */

namespace App\Models\Traits;

trait ActiveField
{
    public function setActive($active = true)
    {
        $this->active = $active;
        $this->save();
    }

    public function isActive()
    {
        return ($this->active ? true : false);
    }
}
