<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Promocode;

class Publishing extends Model
{
    use Translatable, Traits\WithTranslationTrait;

    public $translatedAttributes = ['name', 'code', 'image', 'description'];

    public $rules = [
        'name' => 'required|string',
        'code' => 'required|string'
    ];

    public function promocode()
    {
        return $this->belongsToMany(Promocode::class);
    }

    public function journals()
    {
        return $this->belongsToMany(Journal::class);
    }

    public function scopeWhereTranslationCode($query, $value, $locale = null)
    {
        return $this->scopeWhereTranslation($query, 'code', $value, $locale);
    }
}
