<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Order;
use App\OrderLegalUser;
use App\OrderPhysUser;
use App\Paysystem;
use App\User;
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
        switch ($request->get('PERSON_TYPE')) {
            case Order::PHYSICAL_USER:
                $physUser = new OrderPhysUser();
                $physUser->name = $request->get('name');
                $physUser->surname = $request->get('surname');
                $physUser->patronymic = $request->get('patronymic');
                $physUser->phone = $request->get('phone');
                $physUser->email = $request->get('email');
                $physUser->delivery_address = $request->get('delivery_address');
                $physUser->save();

                $this->assocWithUser($physUser, $request->get('name'), $request->get('email'));

                $order->phys_user_id = $physUser->id;
                $order->paysystem()->associate(Paysystem::getByCode($request->get('paysystem_physic')));
                break;

            case Order::LEGAL_USER:
                $legalUser = new OrderLegalUser();
                $legalUser->org_name = $request->get('org_name');
                $legalUser->legal_address = $request->get('legal_address');
                $legalUser->INN = $request->get('INN');
                $legalUser->KPP = $request->get('KPP');
                $legalUser->l_name = $request->get('l_name');
                $legalUser->l_surname = $request->get('l_surname');
                $legalUser->l_patronymic = $request->get('l_patronymic');
                $legalUser->l_email = $request->get('l_email');
                $legalUser->l_phone = $request->get('l_phone');
                $legalUser->l_delivery_address = $request->get('l_delivery_address');

                $legalUser->save();

                $this->assocWithUser($legalUser, $request->get('l_name'), $request->get('l_email'));

                $order->legal_user_id = $legalUser->id;
                $order->paysystem()->associate(Paysystem::getByCode($request->get('paysystem_legal')));
                break;
        }

        $order->orderList = json_encode(Session::get('cart')->items);
        $order->totalPrice = Session::get('cart')->totalPrice;
        $order->save();

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

    private function assocWithUser($model, $name, $email)
    {
        if (!$user = User::where(['email' => $email])->first()) {
            $model->user()->associate(User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make(str_random())
            ]))->save();

            Auth::login($model->user, true);
        } else {
            $model->user()->associate($user)->save();
        }
    }
}
