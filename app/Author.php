<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use Translatable, WithTranslationTrait;

    public $translatedAttributes = ['name'];

//    protected $fillable = ['code'];

    public $rules = [
        'name' => 'required|string',
        'code' => 'required|string'
    ];

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }

    public static function getAlphabet()
    {
        $alphabet = [];
        $authors = self::withTranslation()->get();
        foreach ($authors as $author) {
            $char = substr($author->name, 0, 1);
            if (!in_array($char, $alphabet)) {
                $alphabet[] = $char;
            }
        }

        return $alphabet;
    }
}
