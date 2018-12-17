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

    public function collectPayData() {
            switch ($this->paysystem->code) {
                case Paysystem::ROBOKASSA:
                    $dataset = $this->paysystem->getDataValues();
                    $signature = md5(
                        $dataset->shop_login .
                        ":" . $this->totalPrice .
                        ":" . $this->id .
                        ":" . $dataset->shop_pass .
                        ":Shp_item=1"
                    );

                    return (object) [
                        'type' => $this->paysystem->code,
                        'logo' => $this->paysystem->logo,
                        'description' => $this->paysystem->description,
                        'login' => $dataset->shop_login,
                        'signature' => $signature
                    ];

                    break;
                case Paysystem::SBERBANK:
                    break;
                case Paysystem::INVOICE:
                    break;
            }
    }
}
