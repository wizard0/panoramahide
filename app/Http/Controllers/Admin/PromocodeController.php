<?php

namespace App\Http\Controllers\Admin;

use App\Models\Journal;
use App\Models\Promocode;
use App\Models\Publishing;
use App\Models\Release;

class PromocodeController extends CRUDController
{
    protected $modelName = '\\App\\Models\\Promocode';
    protected $slug = 'promocodes';
    protected $displayAttributes = ['id', 'promocode', 'type'];
    protected $attributeTypes = [
        'promocode' => self::TYPE_STRING,
        'active' => self::TYPE_BOOL,
        'type' => self::TYPE_SELECT,
        'journal_id' => self::TYPE_REL_BELONGS_TO,
        'limit' => self::TYPE_STRING,
        'used' => self::TYPE_STRING,
        'journal_for_releases_id' => self::TYPE_REL_BELONGS_TO,
        'release_begin' => self::TYPE_DATE,
        'release_end' => self::TYPE_DATE,
        'release_limit' => self::TYPE_STRING,
        'journals' => self::TYPE_REL_BELONGS_TO_MANY,
        'publishings' => self::TYPE_REL_BELONGS_TO_MANY,
        'releases' => self::TYPE_REL_BELONGS_TO_MANY
    ];
    protected $select = [
        'type' => [
            Promocode::TYPE_COMMON => 'Common',
            Promocode::TYPE_ON_JOURNAL => 'On Journal',
            Promocode::TYPE_ON_PUBLISHING => 'On Publishing',
            Promocode::TYPE_ON_RELEASE => 'On Release',
            Promocode::TYPE_PUBL_RELEASE => 'Publishing + Release',
            Promocode::TYPE_CUSTOM => 'Custom'
        ]
    ];
    protected $relatedModelName = [
        'journal_id' => Journal::class,
        'journal_for_releases_id' => Journal::class,
        'journals' => Journal::class,
        'publishings' => Publishing::class,
        'releases' => Release::class
    ];
}
