<?php

namespace App\Http\Controllers;

use App\Article;
use App\Cart;
use App\OrderedSubscription;
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
            $quantity = $request->get('quantity');
            if ($request->has('additionalData')) {
                $product = $this->getModel($type, $id, $request->get('additionalData'));
            } else {
                $product = $this->getModel($type, $id);
            }
            $cart = $this->getCart();
            if (!$cart->add($product, $version, $quantity))
                return response()->json([
                    'success' => false,
                    'error' => 'true',
                    'message' => 'No price'
                ]);
            return response()->json([
                'success' => true,
                'header' => $this->updateCart($cart),
            ]);
        }
        return json_encode(['success' => false, 'error' => true, 'message' => 'The request must be AJAX']);
    }

    public function deleteFromCart(Request $request)
    {
        if ($request->ajax()) {
            $cart = $this->getCart();
            $cart->delete($request->get('id'));
            return response()->json([
                'success' => true,
                'header' => $this->updateCart($cart),
                'cart' => view('personal.lk.cart.content', ['cart' => Session::get('cart'), 'displayCheckout' => true])->render(),
            ]);
        }
        return json_encode(['success' => false, 'error' => true, 'message' => 'The request must be AJAX']);
    }

    public function getHeaderCart()
    {
        $cart = Session::get('cart');
        return view('personal.lk.cart.header', compact('cart'))->render();
    }

    private function getModel($type, $id, $additionalData = null)
    {
        switch ($type) {
            case Cart::PRODUCT_TYPE_ARTICLE:
                return Article::where('id', $id)->first();
            case Cart::PRODUCT_TYPE_RELEASE:
                return Release::where('id', $id)->first();
            case Cart::PRODUCT_TYPE_SUBSCRIPTION:
                $orderedSubscription = OrderedSubscription::create($additionalData);
                return $orderedSubscription;
        }
    }

    private function getCart()
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        return new Cart($oldCart);
    }

    private function updateCart($cart)
    {
        if (empty($cart->items)) {
            Session::forget('cart');
        } else {
            Session::put('cart', $cart);
        }

        return $this->getHeaderCart();
    }
}
