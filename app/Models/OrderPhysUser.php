<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderPhysUser extends Model
{
    protected $table = "order_phys_users";

    public $fillable = ['name', 'surname', 'patronymic', 'phone', 'email', 'delivery_address'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFullName()
    {
        return $this->surname
            . " " . $this->name
            . " " . $this->patronymic;
    }

    public function getDeliveryAddress()
    {
        return $this->delivery_address;
    }
}
