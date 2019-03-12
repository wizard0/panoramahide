<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\OrdersUsers;

/**
 * Class for order legal user.
 */
class OrderLegalUser extends Model
{
    use OrdersUsers;

    protected $table = "order_legal_users";

    public $fillable = [
        'org_name', 'legal_address', 'INN', 'KPP', 'l_name', 'l_surname',
        'l_patronymic', 'l_email', 'l_phone', 'l_delivery_address'
    ];


}
