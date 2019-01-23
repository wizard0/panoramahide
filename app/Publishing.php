<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Promocode;

class Publishing extends Model
{
    use Translatable;

    public $translatedAttributes = ['name', 'code', 'image', 'description'];

    public function promocode()
    {
        return $this->belongsToMany(Promocode::class);
    }

    public function journals()
    {
        return $this->belongsToMany(Journal::class);
    }
}
