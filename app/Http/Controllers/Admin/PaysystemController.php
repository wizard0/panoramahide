<?php

namespace App\Http\Controllers\Admin;

class PaysystemController extends CRUDController
{
    protected $displayAttributes = ['id', 'name', 'code'];
    protected $attributeTypes = [
        'name' => self::TYPE_STRING,
        'code' => self::TYPE_STRING,
        'logo' => self::TYPE_STRING,
        'description' => self::TYPE_STRING,
    ];
}
