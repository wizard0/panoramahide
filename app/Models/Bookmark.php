<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    protected $table = 'bookmarks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'owner_type', 'release_id', 'article_id', 'title', 'scroll', 'tag_number',
    ];

    /**
     * Мутатор для html_mark потому что string, чтобы больше нельзя было сохранить
     *
     * @param $value
     */
    public function setHtmlMarkAttribute($value)
    {
        $this->attributes['html_mark'] = str_limit($value, 255, '');
    }
}
