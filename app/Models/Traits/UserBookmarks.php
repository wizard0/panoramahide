<?php
/**
 * @copyright Copyright (c) 2018-2019 "ИД Панорама"
 * @author    Илья Картунин (ikartunin@gmail.com)
 */
namespace App\Models\Traits;

use App\Models\Bookmark;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

/**
 * User bookmark trait
 */
trait UserBookmarks
{
    public function bookmarks()
    {
        // Регулярным выражением проверяем, из какого класса вызван метод трейта
        if (preg_match('#.*\\\\(PartnerUser)$#', __CLASS__, $match)) {
            // Для пользователей партнёров, определяем отношения через таблицу bookmark_partner_user
            return $this->belongsToMany(Bookmark::class, 'bookmark_partner_user', 'user_id', 'bookmark_id');
        } else {
            // Для пользователей панорамы, определяем отношения через таблицу bookmark_user
            return $this->belongsToMany(Bookmark::class, 'bookmark_user', 'user_id', 'bookmark_id');
        }
    }

    /**
     * Создание закладки для пользоватея
     *
     * @param array $data
     * @return mixed
     */
    public function createBookmark(array $data)
    {
        $data = array_merge([
            'owner_type' => (preg_match('#.*\\\\(PartnerUser)$#', __CLASS__) ? 'partner_user' : 'user')
        ], $data);
        $oBookmark = Bookmark::create($data);
        $this->bookmarks()->save($oBookmark);
        return $oBookmark;
    }
}
