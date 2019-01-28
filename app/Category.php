<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Translatable;

    public $translatedAttributes = ['name', 'code', 'image', 'description'];

//    protected $fillable = ['code'];

    public function journals()
    {
        return $this->belongsToMany(Journal::class, 'journal_category');
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_category');
    }
}
