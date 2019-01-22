<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class Publishing extends Model
{
    use Translatable;

    public $translatable = ['name'];

    public function promocode()
    {
        return $this->belongsToMany(Promocode::class);
    }

    public function journals()
    {
        return $this->belongsToMany(Journal::class);
    }
}
