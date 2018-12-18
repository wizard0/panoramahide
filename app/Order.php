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

    public function paysystem()
    {
        return $this->belongsTo(Paysystem::class);
    }

    public function story()
    {
        return $this->hasMany(OrderStory::class);
    }

    public function user()
    {
        if (isset($this->phys_user_id) && $this->phys_user_id) {
            return $this->belongsTo(OrderPhysUser::class, 'phys_user_id');
        } else {
            return $this->belongsTo(OrderLegalUser::class, 'legal_user_id');
        }
    }

    public function getFullUserName()
    {
        return $this->user->getFullName();
    }

    public function getDeliveryAddress()
    {
        return $this->user->getDeliveryAddress();
    }

    public function getDate()
    {
        return date_format(date_create($this->created_at), "d.m.Y");
    }

    public function collectPayData()
    {
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
                $robo = new Robokassa();
                $robo->setId($this->id);
                $robo->setSum($this->totalPrice);
                $robo->setCulture(Payment::CULTURE_RU);
                $robo->setPaymentMethod('RUR');
                $robo->setDescription('test');
                dd();

                return (object)[
//                        'type' => $this->paysystem->code,
                    'description' => $this->paysystem->description,
                    'login' => $dataset->shop_login,
                    'signature' => $signature,
                    'paymentUrl' => $robo->getPaymentUrl()
                ];

            case Paysystem::SBERBANK:
                return (object)[
//                        'type' => $this->paysystem->code,
                    'description' => $this->paysystem->description,
                ];
            case Paysystem::INVOICE:
                break;
        }
    }
}
