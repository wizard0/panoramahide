<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class Publishing extends Model
{
    use Translatable;

    public $translatable = ['name'];

}
