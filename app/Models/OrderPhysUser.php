<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\OrdersUsers;

class OrderPhysUser extends Model
{
    use OrdersUsers;

    protected $table = "order_phys_users";

    public $fillable = ['name', 'surname', 'patronymic', 'phone', 'email', 'delivery_address'];
}
