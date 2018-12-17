<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class OrderLegalUser extends Model
{
    protected $table = "order_legal_users";

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function getFullName() {
        return $this->l_surname
            . " " . $this->l_name
            . " " . $this->l_patronymic;
    }

    public function getDeliveryAddress() {
        return $this->l_delivery_address;
    }
}
