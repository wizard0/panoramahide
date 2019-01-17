<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $table = 'subscriptions';

    const TYPE_PRINTED = 'printed';
    const TYPE_ELECTRONIC = 'electronic';

    const HALFYEAR_1 = 'first';
    const HALFYEAR_2 = 'second';

    const PERIOD_ONCE_MONTH = 'once_at_month';
    const PERIOD_TWICE_MONTH = 'twice_at_month';
    const PERIOD_ONCE_2_MONTH = 'once_at_2_months';
    const PERIOD_ONCE_3_MONTH = 'once_at_3_months';
    const PERIOD_ONCE_HALFYEAR = 'once_at_half_year';

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }
}
