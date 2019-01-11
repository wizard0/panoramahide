<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

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

    public function scopeNewest(Builder $query, $limit = null)
    {
        return (is_numeric($limit))
            ? $query->orderBy('active_date', 'desc')->limit($limit)
            : $query->orderBy('active_date', 'desc');
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
        $sort = $filters['sort_by'];
        $order = isset($filters['order_by']) ? $filters['order_by'] : 'asc';

        $q = self::where('active', 1)->withTranslation();

        switch ($sort) {
            case 'name':
                $q = $q->orderByTranslation('name', $order);
                break;
            case 'date':
                $q = $q->orderBy('active_date', $order);
                break;
        }

        return $q->paginate(10);
    }

}
