<?php

namespace App;

class Cart
{
    public $items = null;
    public $totalPrice = 0;
    public $totalQty = 0;

    const PRODUCT_TYPE_RELEASE = 'release';
    const PRODUCT_TYPE_ARTICLE = 'article';
    const PRODUCT_TYPE_SUBSCRIPTION = 'subscription';

    const VERSION_PRINTED = 'printed';
    const VERSION_ELECTRONIC = 'electronic';

    public function __construct($oldCart)
    {
        if ($oldCart) {
            $this->items = $oldCart->items;
            $this->totalPrice = $oldCart->totalPrice;
            $this->totalQty = $oldCart->totalQty;
        }
    }

    public function add($product, $version) {
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
//            case Subscription::class:
//                break;
        }
        $storedItems = [
            'qty' => 0,
            'type' => $type,
            'version' => $version,
            'price' => $price,
            'product' => $product,
            'id' => $type . $product->id
        ];
        if ($this->items) {
            if (array_key_exists($type . $product->id, $this->items)) {
                $storedItems = $this->items[$type . $product->id];
            }
        }

        $storedItems['qty']++;
        $storedItems['price'] = $price * $storedItems['qty'];
        $this->items[$type . $product->id] = $storedItems;
        $this->totalQty = sizeof($this->items);
        $this->totalPrice += $price;
    }

    public function delete($product, $type) {
        $itemIndex = $type . $product->id;
        $item = $this->items[$itemIndex];
        $itemPrice = $item['price'];
        $itemQty = $item['qty'];

        unset($this->items[$itemIndex]);
        $this->totalQty = sizeof($this->items);
        $this->totalPrice -= $itemPrice * $itemQty;
    }

    public function changeQty($product, $type, $q) {
        $itemIndex = $type . $product->id;
        $item = $this->items[$itemIndex];
        $itemPrice = $item['price'];
        $itemQty = $item['qty'];

        $this->items[$itemIndex]['qty'] = $q;
        $this->totalPrice -= $itemPrice*$itemQty;
        $this->totalPrice += $itemPrice*$q;
        $this->totalQty = sizeof($this->items);
    }
}
