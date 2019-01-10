<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use Translatable;

    public $translatedAttributes = [
        'name', 'code', 'in_HAC_list', 'image', 'description', 'preview_image', 'preview_description',
        'format', 'volume', 'periodicity', 'editorial_board', 'article_index', 'rubrics', 'review_procedure',
        'article_submission_rules', 'chief_editor', 'phone', 'email', 'site', 'about_editor', 'contacts'
    ];

//    protected $fillable = ['code'];

    /**
     * Categories of the journal belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Publish offices of the journal belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function publishings()
    {
        return $this->belongsToMany(Publishing::class);
    }

    public function releases()
    {
        return $this->hasMany(Release::class);
    }

    public function scopeAllNew(Builder $query)
    {
        return $query->orderBy('created_at', 'asc');
    }

    public function scopeByAlphabet(Builder $query)
    {
        return $query->orderBy('name', 'asc');
    }

    public function scopeByCategories(Builder $query)
    {

    }

    public function getLink()
    {
        return route('magazine', ['code' => $this->code]);
    }

    public static function getName($id)
    {
        return (self::where('id', $id)->first())->name;
    }

    public static function getSome($filters)
    {
        if (
            array_key_exists('sort_by', $filters) &&
            Schema::hasColumn('journals', $filters['sort_by'])
        ) {
            $order = array_key_exists('sort_order', $filters)
                ? $filters['sort_order']
                : 'asc';

            return self::where('active', 1)
                ->orderBy($filters['sort_by'], $order)
                ->paginate(10);
        } else {
            return Journal::where('active', 1)->orderBy('name', 'asc')->paginate(10);
        }
    }

}
