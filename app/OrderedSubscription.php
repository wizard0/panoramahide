<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $type
 * @property string $start_month
 * @property string $term
 * @property string $single_price
 * @property string $name
 * @property mixed $journal
 */
class OrderedSubscription extends Model
{
    protected $fillable = ['type', 'start_month', 'term', 'single_price', 'journal_id'];

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    public function order()
    {
        return $this->belongsToMany(Order::class, 'order_product', 'subscription_id', 'order_id')->first();
    }

    public function getNameAttribute()
    {
        return $this->journal->name;
    }

    public function getLink()
    {
        return $this->journal->getLink();
    }

    public function getBegin()
    {
        return substr($this->start_month, 4, 2).'/'.substr($this->start_month, 0, 4);
    }

    public function getType()
    {
        return $this->type === Subscription::TYPE_ELECTRONIC ? 'Электронная' : 'Печатная';
    }

    public function getReleases()
    {
        // Высчитываем дату начала периуда подписки
        $from     = substr($this->start_month, 0, 4).'-'.substr($this->start_month, 4, 2).'-01 00:00:00';
        // Высчитываем дату конца периуда подписки
        $to_month = substr($this->start_month, 4, 2) + $this->term - 1;
        $to_year  = substr($this->start_month, 0, 4);
        if ($to_month > 12) {
            $to_year++;
            $to_month -= 12;
        }
        $to = $to_year.'-'.$to_month.'-31 23:59:59';


        return $this->journal->releases()->whereBetween('active_date', [$from, $to])->get();
    }
}
