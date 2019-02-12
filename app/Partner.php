<?php

namespace App;

use App\Traits\ActiveField;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use ActiveField;

    protected $fillable = [
        'secret_key', 'active'
    ];

    public function users()
    {
        return $this->hasMany(PartnerUser::class);
    }
    public function quotas()
    {
        return $this->hasMany(Quota::class);
    }
}
