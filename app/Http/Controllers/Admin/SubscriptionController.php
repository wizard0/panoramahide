<?php

namespace App\Http\Controllers\Admin;

use App\Journal;
use App\Subscription;

class SubscriptionController extends CRUDController
{
    protected $displayAttributes = ['id', 'type', 'year', 'half_year'];
    protected $attributeTypes = [
        'locale' => self::TYPE_SELECT,
        'journal_id' => self::TYPE_REL_BELONGS_TO,
        'active' => self::TYPE_BOOL,
        'type' => self::TYPE_SELECT,
        'year' => self::TYPE_STRING,
        'half_year' => self::TYPE_SELECT,
        'period' => self::TYPE_SELECT,
        'price_for_release' => self::TYPE_PRICE,
        'price_for_half_year' => self::TYPE_PRICE,
        'price_for_year' => self::TYPE_PRICE
    ];

    protected $select = [
        'type' => [
            Subscription::TYPE_ELECTRONIC => 'admin.subscription type electronic',
            Subscription::TYPE_PRINTED => 'admin.subscription type printed',
        ],
        'half_year' => [
            Subscription::HALFYEAR_1 => 'First Half Year',
            Subscription::HALFYEAR_2 => 'Second Half Year',
        ],
        'period' => [
            Subscription::PERIOD_ONCE_MONTH => 'Once at Month',
            Subscription::PERIOD_TWICE_MONTH => 'Twice at Month',
            Subscription::PERIOD_ONCE_2_MONTH => 'Once at 2 Months',
            Subscription::PERIOD_ONCE_3_MONTH => 'Once at 3 Months',
            Subscription::PERIOD_ONCE_HALFYEAR => 'Once at Half Year'
        ]
    ];

    protected $relatedModelName = [
        'journal_id' => Journal::class
    ];
}
