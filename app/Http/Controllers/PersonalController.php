<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

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
}
