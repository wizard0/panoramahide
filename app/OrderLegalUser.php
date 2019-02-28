<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

/**
 * Class for order legal user.
 */
class OrderLegalUser extends Model
{
    protected $table = "order_legal_users";

    public $fillable = [
        'org_name', 'legal_address', 'INN', 'KPP', 'l_name', 'l_surname',
        'l_patronymic', 'l_email', 'l_phone', 'l_delivery_address'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFullName()
    {
        return $this->l_surname
            . " " . $this->l_name
            . " " . $this->l_patronymic;
    }

    public function getDeliveryAddress()
    {
        return $this->l_delivery_address;
    }
}
