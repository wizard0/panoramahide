<?php

namespace App\Models;

use App\Journal;
use Illuminate\Database\Eloquent\Model;

class JbyPromo extends Model
{
    public $table = 'jby_promo';

    public $fillable = [
        'promo_user_id', 'promocode_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function journals()
    {
        return $this->belongsToMany(Journal::class, 'jby_promo_journal');
    }
}
