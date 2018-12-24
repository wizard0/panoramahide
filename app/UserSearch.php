<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserSearch extends Model
{
    protected $table = 'user_search';

    const TYPE_ARTICLE = 'article';
    const TYPE_JOURNAL = 'journal';

    public static function retrieve()
    {
        if (Auth::check()) { // Is  authenticated?
            $savedSearch = self::where('user_id', Auth::id())->get();
            $search = [];
            foreach ($savedSearch as $s) {
                $search[$s->id] = (object) [];
                foreach (json_decode($s->search_params) as $value) {
                    $search[$s->id]->{$value->name} = $value->value;
                }
                $search[$s->id]->created = $s->created_at;
            }

            return $search;
        } else {
            return [];
        }
    }
}
