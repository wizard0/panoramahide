<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderLegalUser;
use App\Models\OrderPhysUser;
use App\Models\Paysystem;
use Chelout\Robokassa\Robokassa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Lexty\Robokassa\Payment;
use Session;
use Redirect;

class PersonalController extends Controller
{
    public function cart()
    {
        if (Session::has('cart')) {
            $cart = Session::get('cart');
        } else {
            $cart = null;
        }
        return view('personal.cart', compact('cart'));
    }

    public function orderMake()
    {
        if (Session::has('cart') && Session::get('cart')->totalQty > 0) {
            return view('personal.order_make');
        }
        return Redirect::back();
    }

    public function processOrder(Request $request)
    {
        // saving order data
        $order = new Order();
        $order->saveOrder($request->all());

        // cart clean up
        Session::forget('cart');
        return redirect()->route('order.complete', [
            'id' => $order->id,
            'paysystem' => $order->paysystem
        ]);
    }

    public function completeOrder($id)
    {
        $order = Order::where('id', $id)->first();

        $payData = $order->collectPayData();

        return view('personal.order_complete', compact(
            'order',
            'payData'
        ));
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->to('/personal');
        } else {
            return redirect()->back();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->back();
    }

    public function index(Request $request)
    {
        echo "hello wizard its personal main page";
    }
}
