<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use Translatable, WithTranslationTrait;

    public $translatedAttributes = ['name', 'code', 'description', 'image', 'preview', 'preview_image'];

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
