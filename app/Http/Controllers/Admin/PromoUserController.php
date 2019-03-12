<?php

namespace App\Http\Controllers\Admin;

use App\Models\Promocode;
use App\Models\Publishing;
use App\Models\Release;
use App\Models\User;

class PromoUserController extends CRUDController
{
    protected $modelName = '\\App\\Models\\PromoUser';
    protected $slug = 'promo_userz';
    protected $displayAttributes = ['id', 'name', 'user_id'];
    protected $attributeTypes = [
        'name' => self::TYPE_STRING,
        'user_id' => self::TYPE_REL_BELONGS_TO,
        'phone' => self::TYPE_STRING,
        'promocodes' => self::TYPE_REL_BELONGS_TO_MANY,
        'publishings' => self::TYPE_REL_BELONGS_TO_MANY,
        'releases' => self::TYPE_REL_BELONGS_TO_MANY
    ];

    protected $relatedModelName = [
        'user_id' => User::class,
        'promocodes' => Promocode::class,
        'publishings' => Publishing::class,
        'releases' => Release::class
    ];
}
