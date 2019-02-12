<?php

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
