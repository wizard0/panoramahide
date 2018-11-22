<?php

namespace App;

use App\Translate\ReleaseTranslate;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Release extends Model
{
    use Translatable;

    public $translatedAttributes = ['name', 'code', 'image', 'description', 'preview_image', 'preview_description'];
//    protected $fillable = ['code'];

    /**
     * The model with translation of all entities
     *
     * @var string
     */
    protected $translationModel = ReleaseTranslate::class;

    /**
     * Journal the release belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function journal() {
        return $this->belongsTo(Journal::class);
    }
}
