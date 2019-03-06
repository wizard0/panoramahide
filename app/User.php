<?php

namespace App;

use App\Models\PromoUser;
use App\Order;
use Illuminate\Database\Eloquent\Relations\Relation;

use App\Models\Traits\UserBookmarks;
use App\Models\Traits\UsersDevices;

use Carbon\Carbon;
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
    use UsersDevices;
    use UserBookmarks;

    const PERMISSION_ADMIN = 'web admin';
    const ROLE_ADMIN = 'admin';
    const ROLE_SUPERADMIN = 'super-admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'private', 'name', 'last_name', 'second_name', 'email', 'phone', 'password', 'gender', 'version', 'agree', 'birthday', 'notes', 'country', 'title'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = [
        'birthday'
    ];

    public function setBirthdayAttribute($value)
    {
        $this->attributes['birthday'] = Carbon::parse($value);
    }

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

    public function orders()
    {
        $physUsers  = OrderPhysUser::whereUserId($this->id)->pluck('id')->toArray();
        $legalUsers = OrderLegalUser::whereUserId($this->id)->pluck('id')->toArray();
        $orders     = Order::where(function ($query) use($physUsers, $legalUsers) {
                                $query->whereIn('phys_user_id', $physUsers)
                                      ->orWhereIn('legal_user_id', $legalUsers);
                            });
        return $orders;
    }
}
