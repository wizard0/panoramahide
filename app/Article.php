<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class Article extends Model
{
    use Translatable;

    public $translatable = [
        'name', 'code', 'keywords', 'image', 'description', 'preview_image', 'preview_description', 'bibliography'
    ];
//    protected $fillable = ['active'];

    public function release() {
        return $this->belongsTo(Release::class);
    }

    public function authors() {
        return $this->belongsToMany(Author::class);
    }

    public function categories() {
        return $this->belongsToMany(Category::class);
    }

    public function getUrl() {
        return '/articles/' . $this->code . '.html';
    }
}
