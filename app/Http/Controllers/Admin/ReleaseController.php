<?php

namespace App\Http\Controllers\Admin;

use App\Models\Journal;
use App\Models\Promocode;
use Illuminate\Http\Request;

class ReleaseController extends CRUDController
{
    protected $displayAttributes = ['id', 'name', 'code', 'updated_at'];
    protected $attributeTypes = [
        'active' => self::TYPE_BOOL,
        'active_date' => self::TYPE_DATE,
        'journal_id' => self::TYPE_REL_BELONGS_TO,
        'year' => self::TYPE_STRING,
        'promo' => self::TYPE_BOOL,
        'created_at' => self::TYPE_DATE,
        'updated_at' => self::TYPE_DATE,
        'name' => self::TYPE_STRING,
        'code' => self::TYPE_STRING,
        'number' => self::TYPE_STRING,
        'image' => self::TYPE_IMAGE,
        'description' => self::TYPE_TEXT,
        'preview_image' => self::TYPE_STRING,
        'preview_description' => self::TYPE_TEXT,
        'price_for_electronic' => self::TYPE_STRING,
        'price_for_printed' => self::TYPE_STRING,
        'price_for_articles' => self::TYPE_STRING,
        'promocode' => self::TYPE_REL_BELONGS_TO_MANY
    ];

    protected $relatedModelName = [
        'journal_id' => Journal::class,
        'promocode' => Promocode::class
    ];
}
