<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Order;
use App\OrderLegalUser;
use App\OrderPhysUser;
use App\Paysystem;
use App\Services\Toastr\Toastr;
use App\User;
use Chelout\Robokassa\Robokassa;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Lexty\Robokassa\Payment;
use Session;
use Redirect;

class PersonalController extends Controller
{
    public function __construct()
    {
        self::getRouteNameToView();
        View::share('bodyClass', 'body-personal');
    }

    public function orders(Request $request, $id = null)
    {
        $orders = Auth::user()->getOrders($id);
        return view('personal.'.__FUNCTION__, compact('orders', 'id'));
    }

    public function orderMake()
    {
        if (Session::has('cart') && Session::get('cart')->totalQty > 0) {
            return view('personal.orders.make');
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
        return responseCommon()->success([
            'redirect' => route('order.complete', [
                'id' => $order->id,
            ]),
        ], 'Заказ успешно оформлен.');
    }

    public function cancelOrder($id)
    {
        Order::find($id)->update(['status' => Order::STATUS_CANCELLED]);

        return redirect()->back();
    }

    public function completeOrder($id)
    {
        $order = Order::where('id', $id)->first();
        $payData = $order->collectPayData();

        return view('personal.orders.complete', compact(
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
        return view('personal.'.__FUNCTION__);
    }

    public function cart(Request $request)
    {
        $displayCheckout = true;
        $cart = Session::get('cart', null);
        return view('personal.'.__FUNCTION__, compact('cart', 'displayCheckout'));
    }

    public function subscriptions(Request $request)
    {
        return view('personal.'.__FUNCTION__);
    }

    public function profile(Request $request)
    {
        $user = Auth::user();
        if ($request->ajax()) {
            $validation = Validator::make($request->all(), [
                'gender' => ['required'],
                'version' => ['required'],
            ], [], [
                'gender' => 'Пол',
                'version' => 'Версии журнала',
            ]);
            if ($validation->fails()) {
                return responseCommon()->validationMessages($validation);
            }
            $user->update($request->all());

            return responseCommon()->success([], 'Данные успешно обновлены.');
        }
        return view('personal.'.__FUNCTION__, ['user' => $user]);
    }

    public function magazines(Request $request)
    {
        return view('personal.'.__FUNCTION__);
    }

}
