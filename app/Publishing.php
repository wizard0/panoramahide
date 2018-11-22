<?php

namespace App;

use App\Translate\PublishingTranslate;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Publishing extends Model
{
    use Translatable;

    public $translatedAttributes = ['name'];
    protected $fillable = ['code'];

    /**
     * The model with translation of all entities
     *
     * @var string
     */
    protected $translationModel = PublishingTranslate::class;
}
