<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Promocode;

class Release extends Model
{
    use Translatable;

    public $translatedAttributes = ['name', 'code', 'number', 'image', 'description', 'preview_image', 'preview_description'];

//    protected $fillable = ['code'];

    /**
     * Journal the release belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function scopeAllNew(Builder $query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function getUrl()
    {
        return '/magazines/' . $this->journal->code . '/numbers/' . $this->id . '.html';
    }
    public function promocode()
    {
        return $this->belongsToMany(Promocode::class);
    }
}
