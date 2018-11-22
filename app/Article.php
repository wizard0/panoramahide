<?php

namespace App;

use App\Translate\ArticleTranslate;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use Translatable;

    public $translatedAttributes = [
        'name', 'code', 'keywords', 'image', 'description', 'preview_image', 'preview_description', 'bibliography'
    ];
//    protected $fillable = ['active'];

    /**
     * The model with translation of all entities
     *
     * @var string
     */
    protected $translationModel = ArticleTranslate::class;

    public function release() {
        return $this->belongsTo(Release::class);
    }

    public function authors() {
        return $this->belongsToMany(Author::class);
    }

    public function categories() {
        return $this->belongsToMany(Category::class);
    }
}
