<?php

namespace App;

use App\Translate\AuthorTranslate;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use Translatable;

    public $translatedAttributes = ['name'];
//    protected $fillable = ['code'];

    /**
     * The model with translation of all entities
     *
     * @var string
     */
    protected $translationModel = AuthorTranslate::class;
}
