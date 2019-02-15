<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Publishing;

class JournalController extends CRUDController
{
    protected $displayAttributes = ['id', 'name', 'code', 'updated_at'];
    protected $attributeTypes = [
        'journal_locale' => self::TYPE_STRING,
        'active' => self::TYPE_BOOL,
        'active_date' => self::TYPE_DATE,
        'ISSN' => self::TYPE_STRING,
        'price_prev_halfyear' => self::TYPE_BOOL,
        'created_at' => self::TYPE_DATE,
        'updated_at' => self::TYPE_DATE,
        'index_rospechat' => self::TYPE_STRING,
        'index_krp' => self::TYPE_STRING,
        'name' => self::TYPE_STRING,
        'code' => self::TYPE_STRING,
        'in_HAC_list' => self::TYPE_TEXT,
        'image' => self::TYPE_IMAGE,
        'description' => self::TYPE_TEXT,
        'preview_image' => self::TYPE_IMAGE,
        'preview_description' => self::TYPE_TEXT,
        'format' => self::TYPE_STRING,
        'volume' => self::TYPE_STRING,
        'periodicity' => self::TYPE_STRING,
        'editorial_board' => self::TYPE_TEXT,
        'article_index' => self::TYPE_TEXT,
        'rubrics' => self::TYPE_TEXT,
        'review_procedure' => self::TYPE_TEXT,
        'article_submission_rules' => self::TYPE_TEXT,
        'chief_editor' => self::TYPE_STRING,
        'phone' => self::TYPE_STRING,
        'email' => self::TYPE_STRING,
        'site' => self::TYPE_STRING,
        'about_editor' => self::TYPE_TEXT,
        'contacts' => self::TYPE_TEXT,
        'categories' => self::TYPE_REL_BELONGS_TO_MANY,
        'publishings' => self::TYPE_REL_BELONGS_TO_MANY,
    ];

    protected $relatedModelName = [
        'categories' => Category::class,
        'publishings' => Publishing::class
    ];
}
