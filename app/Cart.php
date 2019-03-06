<?php

namespace App;

use Illuminate\Support\Facades\Session;

class Cart
{
    public $items = null;
    public $totalPrice = 0;
    public $totalQty = 0;

    const PRODUCT_TYPE_RELEASE = 'release';
    const PRODUCT_TYPE_ARTICLE = 'article';
    const PRODUCT_TYPE_SUBSCRIPTION = 'subscription';

    const VERSION_PRINTED = Subscription::TYPE_PRINTED;
    const VERSION_ELECTRONIC = Subscription::TYPE_ELECTRONIC;

    public function __construct($oldCart)
    {
        if ($oldCart) {
            $this->items = $oldCart->items;
            $this->totalPrice = $oldCart->totalPrice;
            $this->totalQty = $oldCart->totalQty;
        }
    }

    /**
     * { function_description }
     *
     * @param      object   $product   The product
     * @param      string   $version   The version
     * @param      integer  $quantity  The quantity
     *
     * @return     boolean  ( description_of_the_return_value )
     */
    public function add($product, $version, $quantity = 1)
    {
        $price = 0;
        $type = '';

        switch (get_class($product)) {
            case Release::class:
                $price = $version == self::VERSION_ELECTRONIC
                    ? $product->price_for_electronic
                    : $product->price_for_printed;
                $type = self::PRODUCT_TYPE_RELEASE;
                break;
            case Article::class:
                $price = $product->price;
                $type = self::PRODUCT_TYPE_ARTICLE;
                break;
            case OrderedSubscription::class:
                $price = $product->single_price;
                $type = self::PRODUCT_TYPE_SUBSCRIPTION;
                break;
        }

        if ($price == null || $price == 0) {
            return false;
        }

        $storedItems = (object)[
            'qty' => $quantity,
            'type' => $type,
            'version' => $version,
            'price' => $price,
            'product' => $product,
            'id' => $type . $product->id
        ];
        if ($this->items) {
            if (array_key_exists($type . $product->id, $this->items)) {
                $storedItems = $this->items[$type . $product->id];
                $storedItems->qty++;
            }
        }

        $storedItems->price = $price * $storedItems->qty;
        $this->items[$type . $product->id] = $storedItems;
        $this->totalQty = sizeof($this->items);
        $this->totalPrice += $price;
    }

    public function delete($product, $type)
    {
        $itemIndex = $type . $product->id;
        $item = $this->items[$itemIndex];
        $itemPrice = $item->price;
        $itemQty = $item->qty;

        unset($this->items[$itemIndex]);
        $this->totalQty = sizeof($this->items);
        $this->totalPrice -= $itemPrice * $itemQty;
    }

    public function changeQty($product, $type, $q)
    {
        $itemIndex = $type . $product->id;
        $item = $this->items[$itemIndex];
        $itemPrice = $item->price;
        $itemQty = $item->qty;

        $this->items[$itemIndex]->qty = $q;
        $this->totalPrice -= $itemPrice * $itemQty;
        $this->totalPrice += $itemPrice * $q;
        $this->totalQty = sizeof($this->items);
    }
}
