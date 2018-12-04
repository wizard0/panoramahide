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
    public function addToCart(Request $request) {
        if ($request->ajax()) {
            $type = $request->get('type');
            $id = $request->get('id');
            $version = $request->get('version');
            $product = $this->getModel($type, $id);

            $oldCart = Session::has('cart') ? Session::get('cart') : null;
            $cart = new Cart($oldCart);
            $cart->add($product, $version);
            $request->session()->put('cart', $cart);

            return $this->getHeaderCart();
        }
        return json_encode(['success' => false, 'error' => true, 'message' => 'The request must be AJAX']);
    }

    public function getHeaderCart() {
        $cart = Session::get('cart');
        return view('personal.header_cart', compact('cart'));
    }

    private function getModel($type, $id) {
        switch ($type) {
            case Cart::PRODUCT_TYPE_ARTICLE:
                return Article::find($id);
            case Cart::PRODUCT_TYPE_RELEASE:
                return Release::find($id);
            case Cart::PRODUCT_TYPE_SUBSCRIPTION:
                return Subscription::find($id);
        }
    }
}
