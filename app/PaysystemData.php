<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaysystemData extends Model
{
    protected $table = 'paysystem_data';

    const TYPE_FILE = 'file';
    const TYPE_STRING = 'string';

}
