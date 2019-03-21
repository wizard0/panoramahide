<?php
/**
 * @copyright Copyright (c) 2018-2019 "ИД Панорама"
 * @author
 */
namespace App\Models;

use App\Models\Journal;
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
        $self = Group::create(['name' => $group['name'], 'promocode_id' => $promocode_id]);
        $self->journals()->saveMany(Journal::whereIn('id', $group['journals'])->get());
        return $self;
    }

    /**
     * Возвращает промокоды для группы
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function promocode()
    {
        return $this->belongsTo(Promocode::class);
    }

    /**
     * Возвращает журналы для группы
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function journals()
    {
        return $this->belongsToMany(Journal::class, 'group_journal', 'group_id', 'journal_id');
    }
}
