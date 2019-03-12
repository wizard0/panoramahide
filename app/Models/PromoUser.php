<?php
/**
 * @copyright
 * @author
 */
namespace App\Models;

use App\Models\JbyPromo;
use App\Models\Promocode;
use App\Models\Publishing;
use App\Models\Release;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class for promo user.
 */
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
        $this->attributes['phone'] = preg_replace('/[^0-9]/', '', $value);
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jByPromo()
    {
        return $this->hasMany(JbyPromo::class, 'promo_user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function jByPromocodes()
    {
        return $this->belongsToMany(Promocode::class, 'jby_promo');
    }
}
