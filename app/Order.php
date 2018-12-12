<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = "orders";

    const PHYSICAL_USER = 'physical';
    const LEGAL_USER = 'legal';

    const STATUS_WAIT = 'wait';
    const STATUS_PAYED = 'payed';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_COMPLETED = 'completed';

    public function paysystem() {
        return $this->belongsTo(Paysystem::class);
    }

    public function story() {
        return $this->hasMany(OrderStory::class);
    }
}
