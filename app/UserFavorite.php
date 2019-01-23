<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFavorite extends Model
{
    protected $table = 'user_favorites';

    const TYPE_JOURNAL = 'journal';
    const TYPE_RELEASE = 'release';
    const TYPE_ARTICLE = 'article';
}
