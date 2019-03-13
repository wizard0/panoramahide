<?php

namespace App\Http\Controllers\Admin;

use App\Models\Partner;
use App\Models\Quota;
use App\Models\Release;
use App\Models\User;

class PartnerUserController extends CRUDController
{
    protected $displayAttributes = ['id', 'user_id', 'partner_id'];
    protected $slug = 'partner_users';
    protected $attributeTypes = [
        'user_id' => self::TYPE_REL_BELONGS_TO,
        'active' => self::TYPE_BOOL,
        'partner_id' => self::TYPE_REL_BELONGS_TO,
        'email' => self::TYPE_STRING,
        'quotas' => self::TYPE_REL_BELONGS_TO_MANY,
        'releases' => self::TYPE_REL_BELONGS_TO_MANY
    ];

    protected $relatedModelName = [
        'user_id' => User::class,
        'partner_id' => Partner::class,
        'quotas' => Quota::class,
        'releases' => Release::class
    ];
}
