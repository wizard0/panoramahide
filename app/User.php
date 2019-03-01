<?php

namespace App;

use App\Models\PromoUser;

use App\Models\Traits\UserBookmarks;
use App\Models\Traits\UsersDevices;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use UsersDevices;
    use UserBookmarks;

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

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function searches()
    {
        return $this->hasMany(UserSearch::class);
    }

    public function promo()
    {
        return $this->hasOne(PromoUser::class, 'user_id');
    }

    public function getPhoneFormatAttribute()
    {
        return phoneFormat($this->phone);
    }

/*  public function devices()
    {
        return $this->hasMany(UserDevice::class);
    }
*/
}
