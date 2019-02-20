<?php
/*
 * Copyright (c) 2018-2019 "ИД Панорама"
 * Автор модуля: Илья Картунин (ikartunin@gmail.com)
 */

namespace App\Models\Traits;

use App\Models\Bookmark;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

trait UserBookmarks
{
    public function bookmarks()
    {
        // Регулярным выражением проверяем, из какого класса вызван метод трейта
        if (preg_match('#.*\\\\(PartnerUser)$#', __CLASS__, $match))
            // Для пользователей партнёров, определяем отношения через таблицу bookmark_partner_user
            return $this->belongsToMany(Bookmark::class, 'bookmark_partner_user', 'user_id', 'bookmark_id');
        else
            // Для пользователей панорамы, определяем отношения через таблицу bookmark_user
            return $this->belongsToMany(Bookmark::class, 'bookmark_user', 'user_id', 'bookmark_id');
    }
}
