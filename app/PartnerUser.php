<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PartnerUser extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function partner()
    {
        return $this->belongsTo(Models\Partner::class);
    }

    public function quotas()
    {
        return $this->belongsToMany(Quota::class, 'partner_user_quota');
    }

    public function releases()
    {
        return $this->belongsToMany(Release::class, 'partner_user_release');
    }
}
