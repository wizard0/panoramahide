<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Subscription
 *
 * @property integer   price_for_half_year
 * @property integer   id
 * @property string    locale
 * @property boolean   active
 * @property string   type
 * @property string   year
 * @property string   half_year
 * @property string   period
 * @property integer   price_for_release
 * @property integer   price_for_year
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
    const PERIOD_ONCE = 'once';

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    public function getPrice($year, $month, $term)
    {
        $price = null;
        if ( $term == 6 && ($month == 1 || $month == 6) ) {
            if (!empty($this->price_for_half_year)) {
                $price = $this->price_for_half_year;
            } elseif (!empty($this->price_for_release)) {
                $price = $this->getPriceByReleasePrice($term);
            }
        } elseif ($term == 12 && $month == 1) {
            if (!empty($this->price_for_year)) {
                $price = $this->price_for_year;
            } else {

                $price = $this->getPriceByReleasePrice($term);

            }
        }

        return $price;
    }

    private function getPriceByReleasePrice($term)
    {
        switch ($this->period) {
            case self::PERIOD_ONCE:
                $price = $this->price_for_release;
                break;
            case self::PERIOD_ONCE_MONTH:
            case self::PERIOD_ONCE_HALFYEAR:
                $price = $this->price_for_release * $term;
                break;
            case self::PERIOD_ONCE_2_MONTH:
                $price = $this->price_for_release * $term/2;
                break;
            case self::PERIOD_ONCE_3_MONTH:
                $price = $this->price_for_release * $term/3;
                break;
            case self::PERIOD_TWICE_MONTH:
                $price = $this->price_for_release * $term * 2;
                break;
        }

        return $price;
    }
}
