<?php

namespace App\Models;

use App\Journal;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'promocode_id', 'name',
    ];

    public static function store($group, $promocode_id)
    {
        $Self = self::create(['name' => $group['name'], 'promocode_id' => $promocode_id]);
        $Self->journals()->saveMany(\App\Journal::whereIn('id', $group['journals'])->get());
        return $Self;
    }

    public function promocode()
    {
        return $this->belongsTo(Promocode::class);
    }

    public function journals()
    {
        return $this->belongsToMany(Journal::class, 'groups_journals', 'group_id', 'journal_id');
    }
}
