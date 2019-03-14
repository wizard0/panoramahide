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

    const VERSION_PRINTED = Models\Subscription::TYPE_PRINTED;
    const VERSION_ELECTRONIC = Models\Subscription::TYPE_ELECTRONIC;

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

        $prClass = (preg_match('#(.*)\\\\(.*)$#', get_class($product), $match) ? $match[2] : null);

        switch ($prClass) {
            case 'Release':
                $price = $version == self::VERSION_ELECTRONIC
                    ? $product->price_for_electronic
                    : $product->price_for_printed;
                $type = self::PRODUCT_TYPE_RELEASE;
                break;
            case 'Article':
                $price = $product->price;
                $type = self::PRODUCT_TYPE_ARTICLE;
                break;
            case 'OrderedSubscription':
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
            'id' => $type . $product->id,
            'title' => $product->name,
        ];

        if ($type == self::PRODUCT_TYPE_RELEASE) {
            $storedItems->title = $product->journal->name . ' №' . $product->number . '. ' . $product->year;
        } elseif ($type == self::PRODUCT_TYPE_SUBSCRIPTION) {
            $storedItems->title = $product->journal->name . ' с ' . substr_replace($product->start_month, "/", 4, 0) . ' на ' . $product->term;
        }

        if ($this->items && array_key_exists($type . $product->id, $this->items)) {
            $storedItems = $this->items[$type . $product->id];
            $storedItems->qty++;
        }

        $storedItems->price = $price * $storedItems->qty;
        $this->items[$type . $product->id] = $storedItems;
        $this->totalQty = sizeof($this->items);
        $this->totalPrice += $storedItems->price;

        return true;
    }

    public function delete($id)
    {
        $item = $this->items[$id];
        $itemPrice = $item->price;
        $itemQty = $item->qty;

        unset($this->items[$id]);
        $this->totalQty = sizeof($this->items);
        $this->totalPrice -= $itemPrice * $itemQty;
    }

    public function changeQty($id, $qty)
    {
        $item = $this->items[$id];
        $itemPrice = $item->price;
        $itemQty = $item->qty;

        $this->items[$id]->qty = $qty;
        $this->totalPrice -= $itemPrice * $itemQty;
        $this->totalPrice += $itemPrice * $qty;
        $this->totalQty = sizeof($this->items);
    }
}
