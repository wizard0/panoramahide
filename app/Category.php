<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class Category extends Model
{
    use Translatable;

    public $translatable = ['name', 'code', 'image', 'description'];
//    protected $fillable = ['code'];

}
