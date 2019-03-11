<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class for paysystem data.
 */
class PaysystemData extends Model
{
    protected $table = 'paysystem_data';

    const TYPE_FILE = 'file';
    const TYPE_STRING = 'string';
}
