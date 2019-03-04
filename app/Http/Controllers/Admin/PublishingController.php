<?php

namespace App\Http\Controllers\Admin;

use App\Journal;
use App\Models\Promocode;

class PublishingController extends CRUDController
{
    protected $displayAttributes = ['id', 'name', 'code', 'updated_at'];
    protected $attributeTypes = [
        'active' => self::TYPE_BOOL,
        'sort' => self::TYPE_STRING,
        'created_at' => self::TYPE_DATE,
        'updated_at' => self::TYPE_DATE,
        'name' => self::TYPE_STRING,
        'code' => self::TYPE_STRING,
        'image' => self::TYPE_IMAGE,
        'description' => self::TYPE_TEXT,
        'promocode' => self::TYPE_REL_BELONGS_TO_MANY,
        'journals' => self::TYPE_REL_BELONGS_TO_MANY
    ];

    protected $relatedModelName = [
        'promocode' => Promocode::class,
        'journals' => Journal::class
    ];
}
