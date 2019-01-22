<?php

namespace App;

use App\Http\Traits\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Release extends Model
{
    use Translatable;

    public $translatable = ['name', 'code', 'image', 'description', 'preview_image', 'preview_description'];
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
