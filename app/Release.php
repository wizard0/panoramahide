<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class Release extends Model
{
    use Translatable;

    public $translatable = ['name', 'code', 'image', 'description', 'preview_image', 'preview_description'];
//    protected $fillable = ['code'];

    /**
     * Journal the release belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function journal() {
        return $this->belongsTo(Journal::class);
    }

    public function articles() {
        return $this->hasMany(Article::class);
    }
}
