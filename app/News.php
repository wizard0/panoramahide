<?php

namespace App;

use App\Translate\NewsTranslate;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use Translatable;

    public $translatedAttributes = ['name', 'code', 'description', 'image', 'preview', 'preview_image'];
//    protected $fillable = ['code'];

    /**
     * The model with translation of all entities
     *
     * @var string
     */
    protected $translationModel = NewsTranslate::class;

    /**
     * Publishing boards the news belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function publishings() {
        return $this->belongsToMany(Publishing::class);
    }
}
