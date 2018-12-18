<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromoUser extends Model
{
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
