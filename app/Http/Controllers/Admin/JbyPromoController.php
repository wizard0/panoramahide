<?php

namespace App\Http\Controllers\Admin;

use App\Models\Promocode;
use App\Models\PromoUser;

class JbyPromoController extends CRUDController
{
    protected $modelName = '\\App\\JbyPromo';
    protected $slug = 'jby_promo';
    protected $displayAttributes = ['id', 'promo_user_id', 'promocode_id'];
    protected $attributeTypes = [
        'promo_user_id' => self::TYPE_REL_BELONGS_TO,
        'promocode_id' => self::TYPE_REL_BELONGS_TO,
        'journals' => self::TYPE_REL_BELONGS_TO_MANY
    ];

    protected $relatedModelName = [
        'promo_user_id' => PromoUser::class,
        'promocode_id' => Promocode::class
    ];
}
