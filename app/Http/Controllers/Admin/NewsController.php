<?php

namespace App\Http\Controllers\Admin;

class NewsController extends CRUDController
{
    protected $displayAttributes = ['id', 'name', 'code', 'updated_at'];
    protected $attributeTypes = [
        'active' => self::TYPE_BOOL,
        'publishing_date' => self::TYPE_DATE,
        'created_at' => self::TYPE_DATE,
        'updated_at' => self::TYPE_DATE,
        'name' => self::TYPE_STRING,
        'code' => self::TYPE_STRING,
        'description' => self::TYPE_TEXT,
        'image' => self::TYPE_IMAGE,
        'preview' => self::TYPE_TEXT,
        'preview_image' => self::TYPE_STRING,
        'publishings' => self::TYPE_REL_BELONGS_TO_MANY
    ];
}
