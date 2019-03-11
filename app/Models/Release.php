<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Promocode;

class Release extends Model
{
    use Translatable, Traits\WithTranslationTrait;

    public $translatedAttributes = [
        'name', 'code', 'number', 'image', 'description',
        'preview_image', 'preview_description',
        'price_for_electronic', 'price_for_printed', 'price_for_articles'
    ];

//    protected $fillable = ['code'];

    public $rules = [
        'name' => 'required|string',
        'code' => 'required|string'
    ];

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

    public function userHasPermission($User)
    {
        if (preg_match('#.*\\\\(PartnerUser)$#', get_class($User))) {
            // Пользователь партнёра
            return ($User->releases()->find($this->id) != null ? true : false);
        } else {
            // Пользователь партала
            return true;
        }
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
