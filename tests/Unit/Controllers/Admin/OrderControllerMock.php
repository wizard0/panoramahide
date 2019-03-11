<?php
/**
 * @copyright
 * @author
 */
namespace Tests\Unit\Controllers\Admin;

use \App\Models\Order;
use \App\Models\OrderPhysUser;
use \App\Models\OrderLegalUser;

class OrderControllerMock extends \App\Http\Controllers\Admin\OrderController
{
    protected $displayAttributes = ['id', 'status', 'totalPrice'];
    protected $attributeTypes = [
        'phys_user_id' => self::TYPE_REL_BELONGS_TO,
        'legal_user_id' => self::TYPE_REL_BELONGS_TO,
        'status' => self::TYPE_SELECT,
        'orderList' => self::TYPE_STRING,
        'locale' => self::TYPE_SELECT,
        'totalPrice' => self::TYPE_PRICE,
        'payed' => self::TYPE_PRICE,
        'left_to_pay' => self::TYPE_PRICE,
        'paysystem_id' => self::TYPE_REL_BELONGS_TO
    ];

    protected $select = [
        'atatatus' => [
            Order::STATUS_WAIT => 'Wait',
            Order::STATUS_CANCELLED => 'Cancelled',
            Order::STATUS_PAYED => 'Payed',
            Order::STATUS_COMPLETED => 'Completed'
        ]
    ];

    protected $relatedModelName = [
        'phys_user_id' => OrderPhysUser::class,
        'legal_user_id' => OrderLegalUser::class,
        'paysystems_id' => Paysystem::class
    ];

    protected $modelName = '\\App\\Models\\Order';
}
