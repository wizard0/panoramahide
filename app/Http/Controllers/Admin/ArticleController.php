<?php

namespace App\Http\Controllers\Admin;

use App\Article;

class ArticleController extends CRUDController
{
    protected $displayAttributes = ['id', 'name', 'code', 'updated_at'];
    protected $attributeTypes = [
        'active' => self::TYPE_BOOL,
        'active_date' => self::TYPE_DATE,
        'active_end_date' => self::TYPE_DATE,
        'publication_date' => self::TYPE_DATE,
        'sort' => self::TYPE_STRING,
        'release_id' => self::TYPE_REL_BELONGS_TO,
        'pin' => self::TYPE_BOOL,
        'content_restriction' => self::TYPE_SELECT,
        'UDC' => self::TYPE_STRING,
        'created_at' => self::TYPE_DATE,
        'updated_at' => self::TYPE_DATE,
        'name' => self::TYPE_STRING,
        'code' => self::TYPE_STRING,
        'keywords' => self::TYPE_STRING,
        'image' => self::TYPE_IMAGE,
        'description' => self::TYPE_TEXT,
        'preview_image' => self::TYPE_STRING,
        'preview_description' => self::TYPE_TEXT,
        'bibliography' => self::TYPE_TEXT,
        'price' => self::TYPE_PRICE,
        'authors' => self::TYPE_REL_BELONGS_TO_MANY,
        'categories' => self::TYPE_REL_BELONGS_TO_MANY,
    ];

    protected $select = [
        'content_restriction' => [
            Article::RESTRICTION_NO => 'No content restriction',
            Article::RESTRICTION_PAY => 'Pay or subscribe',
            Article::RESTRICTION_REGISTER => 'Registering'
        ]
    ];
}
