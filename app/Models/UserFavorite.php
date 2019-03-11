<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $user_id
 * @property integer $element_id
 * @property string $type
 */
class UserFavorite extends Model
{
    protected $table = 'user_favorites';

    const TYPE_JOURNAL = 'journal';
    const TYPE_RELEASE = 'release';
    const TYPE_ARTICLE = 'article';

    protected $fillable = ['user_id', 'element_id', 'type'];
}
