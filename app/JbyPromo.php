<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JbyPromo extends Model
{
    public $table = 'jby_promo';

    public function journals()
    {
        return $this->belongsToMany(Journal::class, 'jby_promo_journal');
    }
}
