<?php

namespace App\Http\Controllers;

use App\Article;
use App\Cart;
use App\Release;
use App\Subscription;
use Illuminate\Http\Request;
use Session;

class ProductController extends Controller
{
    public function addToCart(Request $request)
    {
        if ($request->ajax()) {
            $type = $request->get('type');
            $id = $request->get('id');
            $version = $request->get('version');

            $product = $this->getModel($type, $id);

            $cart = $this->getCart();
            $cart->add($product, $version);
            return $this->updateCart($cart);
        }
        return json_encode(['success' => false, 'error' => true, 'message' => 'The request must be AJAX']);
    }

    public function deleteFromCart(Request $request)
    {
        if ($request->ajax()) {
            $type = $request->get('type');
            $id = $request->get('id');

            $cart = $this->getCart();
            $product = $this->getModel($type, $id);
            $cart->delete($product, $type);
            return $this->updateCart($cart);
        }
        return json_encode(['success' => false, 'error' => true, 'message' => 'The request must be AJAX']);
    }

    public function getHeaderCart()
    {
        $cart = Session::get('cart');
        return view('personal.header_cart', compact('cart'));
    }

    private function getModel($type, $id)
    {
        switch ($type) {
            case Cart::PRODUCT_TYPE_ARTICLE:
                return Article::find($id);
            case Cart::PRODUCT_TYPE_RELEASE:
                return Release::find($id);
            case Cart::PRODUCT_TYPE_SUBSCRIPTION:
                return Subscription::find($id);
        }
    }

    private function getCart()
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        return new Cart($oldCart);
    }

    private function updateCart($cart)
    {
        Session::put('cart', $cart);
        return $this->getHeaderCart();
    }
}
