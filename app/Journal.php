<?php

namespace App;

use App\Translate\JournalTranslate;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use Translatable;

    public $translatedAttributes = [
        'name', 'code', 'in_HAC_list', 'image', 'description', 'preview_image', 'preview_description',
        'format', 'volume', 'periodicity', 'editorial_board', 'article_index', 'rubrics', 'review_procedure',
        'article_submission_rules'
    ];
//    protected $fillable = ['code'];

    /**
     * The model with translation of all entities
     *
     * @var string
     */
    protected $translationModel = JournalTranslate::class;

    /**
     * Categories of the journal belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories() {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Publish offices of the journal belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function publishings() {
        return $this->belongsToMany(Publishing::class);
    }

    /**
     * Contact of the journal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contact() {
        return $this->belongsTo(JournalContact::class);
    }

    /**
     * Locales allowed to show journal
     */
    public function localeFor() {
        //
    }
}
