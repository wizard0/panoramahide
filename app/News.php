<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class News extends Model
{
    use Translatable;

    public $translatable = ['name', 'code', 'description', 'image', 'preview', 'preview_image'];
//    protected $fillable = ['code'];

    /**
     * Publishing boards the news belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function publishings()
    {
        return $this->belongsToMany(Publishing::class);
    }

    public function scopeAllNew(Builder $query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
