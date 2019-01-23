<?php

namespace App\Models;

use App\Promocode;
use App\Publishing;
use App\Release;
use App\User;
use Illuminate\Database\Eloquent\Model;

class PromoUser extends Model
{
    protected $table = 'promo_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'user_id', 'phone',
    ];

    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = preg_replace('/[^0-9]/','', $value);
    }

    /**
     * User account the Promo-user belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Promo-codes used by this promo-user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function promocodes()
    {
        return $this->belongsToMany(Promocode::class);
    }

    /**
     * Publishing boards which promo-user has access to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function publishings()
    {
        return $this->belongsToMany(Publishing::class);
    }

    /**
     * Releases which promo-user has access to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function releases()
    {
        return $this->belongsToMany(Release::class);
    }
}
