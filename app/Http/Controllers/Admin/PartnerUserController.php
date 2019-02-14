<?php

namespace App\Http\Controllers\Admin;

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
}
