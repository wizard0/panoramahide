<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class Author extends Model
{
    use Translatable;

    public $translatable = ['name'];
//    protected $fillable = ['code'];

    public function articles() {
        $this->belongsToMany(Article::class);
    }

    public static function getAlphabet() {
        $alphabet = [];
        $authors = self::all();
        foreach ($authors as $author) {
            $char = substr($author->name, 0, 1);
            if (!in_array($char, $alphabet)) {
                $alphabet[] = $char;
            }
        }

        return $alphabet;
    }
}
