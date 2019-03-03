<?php

namespace App\Http\Controllers\Admin;

class PartnerController extends CRUDController
{
    protected $displayAttributes = ['id', 'secret_key'];
    protected $attributeTypes = [
        'secret_key' => self::TYPE_STRING,
        'active' => self::TYPE_BOOL
    ];
}
