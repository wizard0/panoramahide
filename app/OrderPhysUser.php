<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderPhysUser extends Model
{
    protected $table = "order_phys_users";

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function getFullName() {
        return $this->surname
            . " " . $this->name
            . " " . $this->patronymic;
    }

    public function getDeliveryAddress() {
        return $this->delivery_address;
    }
}
