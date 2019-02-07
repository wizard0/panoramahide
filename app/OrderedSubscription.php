<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string type
 * @property string start_month
 * @property string term
 * @property string single_price
 * @property string name
 *
 * @property mixed journal
 */
class OrderedSubscription extends Model
{
    protected $fillable = ['type', 'start_month', 'term', 'single_price', 'journal_id'];

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    public function getNameAttribute()
    {
        return $this->journal->name;
    }

    public function getLink()
    {
        return $this->journal->getLink();
    }
}
