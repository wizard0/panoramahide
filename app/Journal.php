<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

/**
 * Class Journal
 *
 * @property integer id
 * @property string locale
 * @property boolean active
 * @property string active_date
 * @property string ISSN
 * @property string name
 * @property string code
 * @property string in_HAC_list
 * @property string image
 * @property string description
 * @property string preview_image
 * @property string preview_description
 * @property string format
 * @property string volume
 * @property string periodicity
 * @property string editorial_board
 * @property string article_index
 * @property string rubrics
 * @property string review_procedure
 * @property string article_submission_rules
 * @property string chief_editor
 * @property string phone
 * @property string email
 * @property string site
 * @property string about_editor
 * @property string contacts
 * @property mixed  subscriptions
 *
 * @package App
 */
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

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function getLastRelease()
    {
        return $this->releases()->where('active', '1')->orderBy('active_date', 'desc')->first();
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
        return route('journal', ['code' => $this->code]);
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


    public function getReleasesByYears()
    {
        $groupedData = [];
        $releases = Release::where('journal_id', $this->id)->orderBy('year', 'desc')->get();
        foreach ($releases as $release) {
            $groupedData[$release->year][] = $release;
        }

        return $groupedData;
    }

    public function getArticlesFresh($pagination)
    {
        $release = $this->getLastRelease();
        return $release->articles()->paginate($pagination);
    }

    public function getArticlesAll($pagination)
    {
        $releasesIds = [];
        $releases = DB::table('releases')->select('id')->where('journal_id', $this->id)->get();
        foreach ($releases as $r) {
            $releasesIds[] = $r->id;
        }

        return Article::whereIn('release_id', $releasesIds)->paginate($pagination);
    }

    public function getSubscriptionsByTypes()
    {
        $subscriptions = $this->subscriptions;
        $byType = [];
        foreach ($subscriptions as $s) {
            $byType[$s->type] = $s;
        }

        return $byType;
    }

    /**
     * This functions compiles subscriptions data as convenient array
     *
     * return array
     */
    public function getSubscriptionsCombos()
    {
        $subscriptions = $this->subscriptions;
        $combos = [];
        foreach ($subscriptions as $s) {
            foreach([1, 2, 3, 4, 5, 6, 12] as $term) {

                if ($s->period == Subscription::PERIOD_ONCE_2_MONTH)
                    if ($term == 1 || $term == 3 || $term == 5) continue;
                if ($s->period == Subscription::PERIOD_ONCE_3_MONTH)
                    if ($term != 3 && $term != 6 && $term != 12) continue;
                if ($s->period == Subscription::PERIOD_ONCE_HALFYEAR)
                    if ($term != 6 && $term != 12) continue;

                for ($year = date("Y"); $year <= date("Y")+2; $year++) {
                    if ($s->year != $year) continue;

                    for ($month = 1; $month <= 12; $month++) {
                        $price = $s->getPrice($year, $month, $term);
                        if ($price) {
                            $combos[$s->type][$term][$year][$month] = $price;
                        }
                    }
                }
            }
        }

        return $combos;
    }
}
