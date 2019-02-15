<?php

namespace App\Http\Controllers\Admin;

use App\Partner;
use App\Quota;
use App\Release;
use App\User;

class PartnerUserController extends CRUDController
{
    protected $displayAttributes = ['id', 'user_id', 'partner_id'];
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
