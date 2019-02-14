<?php

namespace App\Http\Controllers\Admin;

class OrderPhysUserController extends CRUDController
{
    protected $displayAttributes = ['id', 'name'];
    protected $attributeTypes = [
        'name' => self::TYPE_STRING,
        'surname' => self::TYPE_STRING,
        'patronymic' => self::TYPE_STRING,
        'phone' => self::TYPE_STRING,
        'email' => self::TYPE_STRING,
        'delivery_address' => self::TYPE_STRING,
        'user_id' => self::TYPE_REL_BELONGS_TO
    ];
}
