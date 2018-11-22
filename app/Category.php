<?php

namespace App;

use App\Translate\CategoryTranslate;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Translatable;

    public $translatedAttributes = ['name', 'code', 'image', 'description'];
//    protected $fillable = ['code'];

    /**
     * The model with translation of all entities
     *
     * @var string
     */
    protected $translationModel = CategoryTranslate::class;
}
