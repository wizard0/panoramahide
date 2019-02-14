<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Promocode;

class Release extends Model
{
    use Translatable, WithTranslationTrait;

    public $translatedAttributes = [
        'name', 'code', 'number', 'image', 'description',
        'preview_image', 'preview_description',
        'price_for_electronic', 'price_for_printed', 'price_for_articles'
    ];

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

    public function getLink()
    {
        return route('release', ['journalCode' => $this->journal->code, 'releaseID' => $this->id]);
    }
    public function promocode()
    {
        return $this->belongsToMany(Promocode::class);
    }
}
