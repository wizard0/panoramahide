<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function robokassaResult()
    {
        print_r($_REQUEST);
        die();
    }

    public function robokassaSuccess()
    {

    }

    public function robokassaFail()
    {

    }

    public function payment(Request $request)
    {
        $orderId = $request->get('ORDER_ID');
        $order = Order::where('id', $orderId)->first();

        return view('personal.orders.payment.sberbank', compact('order'));
    }
}
