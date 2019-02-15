<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use App\Models\Promocode;

/**
 * Class Journal
 *
 * @property integer id
 * @property string  journal_locale
 * @property boolean active
 * @property string  active_date
 * @property string  ISSN
 * @property boolean price_prev_halfyear
 * @property string  name
 * @property string  code
 * @property string  in_HAC_list
 * @property string  image
 * @property string  description
 * @property string  preview_image
 * @property string  preview_description
 * @property string  format
 * @property string  volume
 * @property string  periodicity
 * @property string  editorial_board
 * @property string  article_index
 * @property string  rubrics
 * @property string  review_procedure
 * @property string  article_submission_rules
 * @property string  chief_editor
 * @property string  phone
 * @property string  email
 * @property string  site
 * @property string  about_editor
 * @property string  contacts
 * @property mixed   subscriptions
 *
 * @package App
 */
class Journal extends Model
{
    use Translatable, WithTranslationTrait;

    public $translatedAttributes = [
        'name', 'code', 'in_HAC_list', 'image', 'description', 'preview_image', 'preview_description',
        'format', 'volume', 'periodicity', 'editorial_board', 'article_index', 'rubrics', 'review_procedure',
        'article_submission_rules', 'chief_editor', 'phone', 'email', 'site', 'about_editor', 'contacts'
    ];

    /**
     * Categories of the journal belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'journal_category');
    }

    /**
     * Publish offices of the journal belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function publishings()
    {
        return $this->belongsToMany(Publishing::class, 'journal_publishing');
    }

    public function releases()
    {
        return $this->hasMany(Release::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function getLastRelease(Array $select = [])
    {
        if (is_array($select) && !empty($select)) {
            $last = $this->releases()->select($select)
                ->where('active', '1')->orderBy('active_date', 'desc')->first();
        } else {
            $last = $this->releases()->where('active', '1')->orderBy('active_date', 'desc')->first();
        }
        return $last;
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

        $q->with('releases')->where('active', 1);

        return $q->paginate(10);
    }

    public function getReleasesByYears()
    {
        $groupedData = [];
        $releases = Release::where('journal_id', $this->id)
            ->where('active', 1)
            ->orderBy('year', 'desc')->get();
        foreach ($releases as $release) {
            $groupedData[$release->year][] = $release;
        }

        return $groupedData;
    }

    public function getArticlesFresh($pagination)
    {
        $release = $this->getLastRelease(['id']);
        $articles = Article::where('release_id', $release->id)->where('active', 1)->paginate($pagination);
        return $articles;
    }

    public function getArticlesAll($pagination)
    {
        $releasesIds = [];
        $releases = DB::table('releases')->select('id')
            ->where('active', 1)
            ->where('journal_id', $this->id)
            ->get();
        foreach ($releases as $r) {
            $releasesIds[] = $r->id;
        }

        return Article::whereIn('release_id', $releasesIds)->where('active', 1)->paginate($pagination);
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

    public function getSubscribeInfo()
    {
        $subscribe = array();

        // создать части подписки | generate subscribe parts
        foreach (array(Subscription::TYPE_PRINTED, Subscription::TYPE_ELECTRONIC) as $type) {
            if ($type == Subscription::TYPE_ELECTRONIC) {
//                $start_month = date('n');
                $start_month = 1;
                $start_year = date('Y');
            } else {
                $start_month = (date('d') < 20
                    ? date('n', strtotime('+1 month'))
                    : date('n', strtotime('+2 month')));

                $start_year = ($start_month >= date('m')
                    ? date('Y')
                    : date('Y', strtotime('+1 year')));
            }

            $subs = Subscription::where('active', '=', 1)
                ->where('journal_id', '=', $this->id)
                ->whereIn('year', [$start_year, $start_year + 1])
                ->where('type', '=', $type)
                ->where('locale', '=', App::getLocale())
                ->get();

            foreach ($subs as $sub_info) {
                $subscribe['info'][$sub_info->type][$sub_info->year][$sub_info->half_year] = $sub_info;

                if ($sub_info->year == $start_year && $sub_info->half_year == halfyear($start_month)) {
                    if ($sub_info->half_year == Subscription::HALFYEAR_2) {
                        $new_halfyear = Subscription::HALFYEAR_1;
                        $new_year = $start_year + 1;
                    } else {
                        $new_halfyear = Subscription::HALFYEAR_2;
                        $new_year = $start_year;
                    }
                    // добавить цены на следующее полугодие на основе предыдущего
                    if ($this->price_prev_halfyear) {
                        $subscribe['info'][$sub_info->type][$new_year][$new_halfyear] = $sub_info;
                    }
                }
            }

            $subs = $subscribe['info'];

            for ($length = 1; $length <= 12; $length++) {
                if ($length > 6 && $length < 12) continue;
                // если длина кратна периодичности | if the length is a multiple of the periodicity
                if (array_key_exists(halfyear($start_month), $subs[$type][$start_year]))
                    if (($length * Subscription::$periods[$subs[$type][$start_year][halfyear($start_month)]->period]) % 6 != 0) continue;
                // с текущего месяца в течение года | from the current month during the year
                $arFirstMonth = array();
                // для электронной версии добавить подписку с января
                if ($type == Subscription::TYPE_ELECTRONIC) {
                    $arFirstMonth[] = 1;
                }
                for ($first_month = $start_month; $first_month < $start_month + 12; $first_month++) {
                    $arFirstMonth[] = $first_month;
                }
                foreach ($arFirstMonth as $first_month) {
                    $_month = $first_month;
                    $_year = $start_year;
                    if ($_month > 12) {
                        $_month = $_month - 12;
                        $_year++;
                    }

                    $end_year = $_year;
                    $end_month = $_month + $length/* - 1*/
                    ;
                    if ($end_month > 12) {
                        $end_month = $end_month - 12;
                        $end_year++;
                    }

                    if (!array_key_exists($_year, $subs[$type])) continue;
                    if (!array_key_exists(halfyear($_month), $subs[$type][$_year])) continue;
                    $subscribeObject = $subs[$type][$_year][halfyear($_month)];

                    $price = 0;
                    if ( // длина == 12 месяц | length == 12 month
                        $length == 12
                        && !empty($price_year = $subscribeObject->price_for_year)
                    ) {
                        $price = $price_year;
                    } elseif (
                        $length == 6
                        && $type == Subscription::TYPE_ELECTRONIC
                        && $_month == 6
                        && !empty($subscribeObject->price_for_half_year)
                    ) {
                        $price = $subscribeObject->price_for_half_year;
                    } elseif ( // в одном полугодии | in one halfyear
                        (   // начало в этом полугодии | start in this halfyear
                            halfyear($start_month) == halfyear($_month)
                            && halfyear($start_month) == halfyear($end_month)
                            && $start_year == $end_year
                        )
                        || ( // начало в другом полугодии | start in other halfyear
                            !empty($subs[$type][$_year][halfyear($_month)])
                            && halfyear($_month) == halfyear($end_month)
                            && $_year == $end_year
                            && (
                                ($start_year == $end_year
                                    && halfyear($end_month) == Subscription::HALFYEAR_2)
                                ||
                                (halfyear($end_month) == Subscription::HALFYEAR_1
                                    && halfyear($start_month) == Subscription::HALFYEAR_2)
                            )
                        )
                    ) {
                        if (($length * Subscription::$periods[$subscribeObject->period]) % 6) continue;
                        $price = $subscribeObject->price_for_release * Subscription::$periods[$subscribeObject->period] * $length / 6;
                    } elseif ( // в 2 или 3 разных полугодиях и начало в этому полугодии | in 2 or 3 differents halfyears and start in this halfyear
                        halfyear($start_month) == halfyear($_month)
                        && $_year == $start_year
                        && (
                            (halfyear($_month) == Subscription::HALFYEAR_1
                                && halfyear($end_month) == Subscription::HALFYEAR_2
                                && $end_year == $_year)
                            ||
                            (halfyear($_month) == Subscription::HALFYEAR_2
                                && halfyear($end_month) == Subscription::HALFYEAR_1
                                && $end_year == $_year + 1)
                        )
                    ) {
                        $halfyear = halfyear($_month) == Subscription::HALFYEAR_1
                            ? 1
                            : 2;
                        $count_month1 = $halfyear * 6 - $_month + 1;
                        $count_month2 = $length - $count_month1;
                        $count_month3 = $price3 = 0;

                        $_end_year = $end_year;
                        $_end_month = $end_month;
                        // если 3 части | if 3 parts
                        if ($count_month2 > 6) {
                            $count_month3 = $count_month2 - 6;
                            $count_month2 = 6;
                            if (halfyear($_month) == Subscription::HALFYEAR_1) {
                                $end_year--;
                            }

                            $end_month = $_month + $count_month1 + $count_month2 - 1;
                            if ($end_month > 12) {
                                $end_month = $end_month - 12;
                            }
                        }
                        $price1 = $price2 = 0;
                        if ($count_month1 <= 6 && ($count_month1 * Subscription::$periods[$subscribeObject->period]) % 6 == 0) {
                            if ($count_month1 == 6 && !empty($price_halfyear = $subscribeObject->price_for_half_year)) {
                                $price1 = $price_halfyear;
                            } else {
                                $price1 = $subscribeObject->price_for_release * Subscription::$periods[$subscribeObject->period] * $count_month1 / 6;
                            }
                        }
                        $subscribeEnd = $subs[$type][$end_year][halfyear($end_month)];
                        if ($count_month2 <= 6 && ($count_month2 * Subscription::$periods[$subscribeEnd->period]) % 6 == 0) {
                            if ($count_month2 == 6 && !empty($price_halfyear = $subscribeEnd->price_for_half_year)) {
                                $price2 = $price_halfyear;
                            } else {
                                $price2 = $subscribeEnd->price_for_release * Subscription::$periods[$subscribeEnd->period] * $count_month2 / 6;
                            }
                        }
                        $subscribeEnd2 = $subs[$type][$_end_year][halfyear($_end_month)];
                        if ($count_month3) {
                            if (empty($subscribeEnd2)) {
                                $price3 = $subscribeEnd->price_for_release * Subscription::$periods[$subscribeEnd->period] * $count_month3 / 6;
                            } else {
                                $price3 = $subscribeEnd2->price_for_release * Subscription::$periods[$subscribeEnd2->period] * $count_month3 / 6;
                            }

                        }
                        if ($price1/* && $price2*/) {
                            $price = $price1 + $price2 + $price3;
                        }
                    } else {
                        // if ($type == 'ELECTRON')
                        // {
                        //     pre(array(
                        //         'length' => $length,
                        //         '_month' => $_month,
                        //         '_year' => $_year,
                        //         'end_month' => $end_month,
                        //         'end_year' => $end_year,
                        //     ));
                        // }
                    }
                    // установить цену | set price
                    if ($price) {
                        $subscribe['prices'][$type][$length][$_year][$_month] = $price;
                    }
                }
            }
        }

        return $subscribe;
    }

    public function promocode()
    {
        return $this->belongsToMany(Promocode::class, 'promocode_journal');
    }

    public function groups()
    {
        return $this->belongsToMany(Journal::class, 'group_journal');
    }

}
