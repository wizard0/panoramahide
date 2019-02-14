<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class UserDevice extends Model
{
    protected $table = 'user_devices';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'code', 'name', 'code_at', 'expires_at', 'is_online', 'status',
    ];

    public $dates = [
        'code_at',
        'expires_at'
    ];

    private $statuses = [
        0 => 'Не активно',
        1 => 'Активно, ждет подтверждения',
        2 => 'Активно, подтверждено',
        3 => 'Не активно, истек срок',
    ];

    public function scopeActive(Builder $query)
    {
        return $query->whereIn('status', [2])
            ->where('expires_at', '>=', now());
    }
}
