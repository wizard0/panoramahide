<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Article extends Model
{
    use Translatable, WithTranslationTrait;

    const RESTRICTION_NO = 'no';
    const RESTRICTION_REGISTER = 'register';
    const RESTRICTION_PAY = 'pay/subscribe';

    public $translatedAttributes = [
        'name', 'code', 'keywords', 'image', 'description',
        'preview_image', 'preview_description', 'bibliography', 'price'
    ];

    public function release()
    {
        return $this->belongsTo(Release::class);
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function userFavorites()
    {
        return $this->hasMany(UserFavorite::class, 'element_id', 'id');
    }

    public function scopeFavorites()
    {
        return $this->whereHas('userFavorites', function($query) {
            $query->where('type', UserFavorite::TYPE_ARTICLE)
                ->where('user_id', Auth::id());
        });
    }

    public function getLink()
    {
        return route('article', ['code' => $this->code]);
    }
}
