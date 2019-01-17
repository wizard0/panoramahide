<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

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

    public function scopeNewest(Builder $query, $limit = null)
    {
        return (is_numeric($limit))
            ? $this->orderBy('active_date', 'desc')->limit($limit)
            : $this->orderBy('active_date', 'desc');
    }

    public function scopeNewestTranslated(Builder $query, $limit = null)
    {
        return (is_numeric($limit))
            ? $this->orderBy('active_date', 'desc')->limit($limit)->withTranslation()
            : $this->orderBy('active_date', 'desc')->withTranslation();
    }

    public function getUrl()
    {
        return route('release', ['journalCode' => $this->journal->code, 'releaseID' => $this->id]);
    }
}
