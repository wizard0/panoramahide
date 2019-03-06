<?php

namespace App\Http\Controllers\Admin;

class UserController extends CRUDController
{
    protected $displayAttributes = ['id', 'name', 'email'];
    protected $attributeTypes = [
        'name' => self::TYPE_STRING,
        'last_name' => self::TYPE_STRING,
        'email' => self::TYPE_STRING,
        'phone' => self::TYPE_STRING,
        'email_verified_at' => self::TYPE_DATE,
        'password' => self::TYPE_STRING,
        'private' => self::TYPE_BOOL,
        'remember_token' => self::TYPE_STRING
    ];
}
