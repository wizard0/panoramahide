<?php

namespace App\Http\Controllers\Admin;

class PromoUserController extends CRUDController
{
    protected $modelName = '\\App\\Models\\PromoUser';
    protected $slug = 'promo_users';
    protected $displayAttributes = ['id', 'name', 'user_id'];
    protected $attributeTypes = [
        'name' => self::TYPE_STRING,
        'user_id' => self::TYPE_REL_BELONGS_TO,
        'phone' => self::TYPE_STRING,
        'promocodes' => self::TYPE_REL_BELONGS_TO_MANY,
        'publishings' => self::TYPE_REL_BELONGS_TO_MANY,
        'releases' => self::TYPE_REL_BELONGS_TO_MANY
    ];
}
