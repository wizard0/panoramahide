<?php

namespace App\Http\Controllers\Admin;

class AuthorController extends CRUDController
{
    protected $displayAttributes = ['id', 'name', 'locale', 'updated_at'];
    protected $attributeTypes = [
        'author_language' => self::TYPE_STRING,
        'created_at' => self::TYPE_DATE,
        'updated_at' => self::TYPE_DATE,
        'name' => self::TYPE_STRING,
        'articles' => self::TYPE_REL_BELONGS_TO_MANY,
    ];
}
