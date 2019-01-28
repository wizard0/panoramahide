<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Publishing extends Model
{
    use Translatable;

    public $translatedAttributes = ['name', 'code', 'image', 'description'];
}
