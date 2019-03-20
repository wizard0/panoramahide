<?php
/**
 * @copyright Copyright (c) 2018-2019 "ИД Панорама"
 * @author
 */
namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Article extends Model
{
    use Translatable, Traits\WithTranslationTrait;

    const RESTRICTION_NO = 'no';
    const RESTRICTION_REGISTER = 'register';
    const RESTRICTION_PAY = 'pay/subscribe';

    public $translatedAttributes = [
        'name', 'code', 'keywords', 'image', 'description',
        'preview_image', 'preview_description', 'bibliography', 'price'
    ];

    public $rules = [
        'name' => 'required|string',
        'code' => 'required|string'
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
        return $this->whereHas('userFavorites', function ($query) {
            $query->where('type', UserFavorite::TYPE_ARTICLE)
                ->where('user_id', Auth::id());
        });
    }

    public function getLink()
    {
        return route('article', ['code' => $this->code]);
    }

    /**
     * Эта область фильтрации результатов путем проверки полей перевода.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string                                $value
     * @param string                                $locale
     *
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function scopeWhereTranslationCode(Builder $query, $value, $locale = null)
    {
        return $this->scopeWhereTranslation($query, 'code', $value, $locale);
    }
}
