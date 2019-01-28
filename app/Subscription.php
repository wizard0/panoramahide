<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Subscription
 *
 * @property integer price_for_half_year
 * @property integer id
 * @property string  locale
 * @property boolean active
 * @property string  type
 * @property string  year
 * @property string  half_year
 * @property string  period
 * @property integer price_for_release
 * @property integer price_for_year
 *
 * @package App
 */
class Subscription extends Model
{
    use Translatable;

    protected $table = 'subscriptions';

    public $translatedAttributes = [
        'price_for_release', 'price_for_half_year', 'price_for_year'
    ];

    const TYPE_PRINTED = 'printed';
    const TYPE_ELECTRONIC = 'electronic';

    const HALFYEAR_1 = 'first';
    const HALFYEAR_2 = 'second';

    const PERIOD_ONCE_MONTH = 'once_at_month';
    const PERIOD_TWICE_MONTH = 'twice_at_month';
    const PERIOD_ONCE_2_MONTH = 'once_at_2_months';
    const PERIOD_ONCE_3_MONTH = 'once_at_3_months';
    const PERIOD_ONCE_HALFYEAR = 'once_at_half_year';

    static $periods = [
        self::PERIOD_ONCE_HALFYEAR => 1,
        self::PERIOD_ONCE_MONTH => 6,
        self::PERIOD_TWICE_MONTH => 12,
        self::PERIOD_ONCE_2_MONTH => 3,
        self::PERIOD_ONCE_3_MONTH => 2,
    ];

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }
}
