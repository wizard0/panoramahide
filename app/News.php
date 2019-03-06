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

    public $rules = [
        'name' => 'required|string',
        'code' => 'required|string'
    ];

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
