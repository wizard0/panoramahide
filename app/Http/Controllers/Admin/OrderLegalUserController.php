<?php

namespace App\Http\Controllers\Admin;

use App\User;

class OrderLegalUserController extends CRUDController
{
    protected $slug = 'order_legal_users';
    protected $displayAttributes = ['id', 'org_name'];
    protected $attributeTypes = [
        'org_name' => self::TYPE_STRING,
        'legal_address' => self::TYPE_STRING,
        'INN' => self::TYPE_STRING,
        'KPP' => self::TYPE_STRING,
        'l_name' => self::TYPE_STRING,
        'l_surname' => self::TYPE_STRING,
        'l_patronymic' => self::TYPE_STRING,
        'l_email' => self::TYPE_STRING,
        'l_delivery_address' => self::TYPE_STRING,
        'l_phone' => self::TYPE_STRING,
        'user_id' => self::TYPE_REL_BELONGS_TO
    ];

    protected $relatedModelName = [
        'user_id' => User::class
    ];
}
