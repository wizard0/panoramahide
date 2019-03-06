<?php

namespace App\Http\Controllers\Admin;

use App\Journal;
use App\Models\Partner;
use App\Release;

class QuotaController extends CRUDController
{
    protected $displayAttributes = ['id', 'partner_id', 'used'];
    protected $attributeTypes = [
        'active' => self::TYPE_BOOL,
        'partner_id' => self::TYPE_REL_BELONGS_TO,
        'journal_id' => self::TYPE_REL_BELONGS_TO,
        'release_id' => self::TYPE_REL_BELONGS_TO,
        'release_begin' => self::TYPE_DATE,
        'release_end' => self::TYPE_DATE,
        'quota_size' => self::TYPE_STRING,
        'used' => self::TYPE_STRING
    ];
    protected $relatedModelName = [
        'partner_id' => Partner::class,
        'journal_id' => Journal::class,
        'release_id' => Release::class
    ];
}
