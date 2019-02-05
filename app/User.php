<?php

namespace App;

use App\Models\PromoUser;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property string name
 * @property string last_name
 * @property string  phone
 */
class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    const PERMISSION_ADMIN = 'web admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'private', 'name', 'last_name', 'email', 'phone', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function searches(): Relation
    {
        return $this->hasMany(UserSearch::class);
    }

    public function promo(): Relation
    {
        return $this->hasOne(PromoUser::class, 'user_id');
    }

    public function getPhoneFormatAttribute(): string
    {
        return phoneFormat($this->phone);
    }

    public function getFullNameAttribute(): string
    {
        return $this->name . ' ' . $this->last_name;
    }
}
