<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;

class AuthorController extends CRUDController
{
    protected $displayAttributes = ['id', 'name', 'updated_at'];
    protected $attributeTypes = [
        'author_language' => self::TYPE_STRING,
        'created_at' => self::TYPE_DATE,
        'updated_at' => self::TYPE_DATE,
        'name' => self::TYPE_STRING,
        'articles' => self::TYPE_REL_BELONGS_TO_MANY,
    ];

    protected $relatedModelName = [
        'articles' => Article::class
    ];
}
