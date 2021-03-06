<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App;

/**
 * Class for user search.
 */
class UserSearch extends Model
{
    protected $fillable = ['user_id', 'search_params'];

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
                if (!isset($search[$s->id]->type)) {
                    $search[$s->id]->type = UserSearch::TYPE_ARTICLE;
                }
            }

            return $search;
        } else {
            return [];
        }
    }

    public static function search($params)
    {
        $searchLocale = App::getLocale();
        $groupBy = 'article_translations.code';

        switch ($params['type']) {
            case 'journal':
                $groupBy = 'journal_translations.code';
                $q = Journal::selectRaw("
                        journals.id as journalID,
                        journal_translations.image as journalImage,
                        journals.issn as journalISSN,
                        journal_translations.name as journalName,
                        journal_translations.code as journalCode,
                        release_translations.name as releaseName,
                        release_translations.code as releaseCode
                    ")
                    ->leftJoin('releases', 'releases.journal_id', '=', 'journals.id')
                    ->leftJoin('articles', 'releases.id', '=', 'articles.release_id');

                break;
            default:
                if (isset($params['q']) && $params['q']) {
                    $q = Article::selectRaw("
                            article_translations.name as articleName,
                            articles.id as articleID,
                            article_translations.code as articleCode,
                            article_translations.description as articleDescr,
                            author_translations.name as authorName,
                            authors.id as authorID,
                            journal_translations.name as journalName,
                            journal_translations.code as journalCode,
                            releases.id as releaseID,
                            release_translations.name as releaseName,
                            release_translations.code as releaseCode,
                            release_translations.number as releaseNumber,
                            articles.active_date as articleActiveDate,
                            CASE
                                WHEN article_translations.description like '%{$params['q']}%'
                                  THEN article_translations.description
                                  ELSE null
                            END as found
                        ");
                } else {
                    $q = Article::selectRaw("
                            article_translations.name as articleName,
                            articles.id as articleID,
                            article_translations.code as articleCode,
                            article_translations.description as articleDescr,
                            author_translations.name as authorName,
                            authors.id as authorID,
                            journal_translations.name as journalName,
                            journal_translations.code as journalCode,
                            releases.id as releaseID,
                            release_translations.name as releaseName,
                            release_translations.code as releaseCode,
                            articles.active_date as articleActiveDate
                        ");
                }
                $q = $q->leftJoin('releases', 'articles.release_id', '=', 'releases.id')
                    ->leftJoin('journals', 'releases.journal_id', '=', 'journals.id');
                if (isset($params) && isset($params['favorite'])) {
                    if (Auth::check()) {
                        $q = $q->rightJoin('user_favorites', 'user_favorites.element_id', '=', 'articles.id')
                            ->where('user_favorites.type', '=', 'article')
                            ->where('user_favorites.user_id', '=', Auth::id());
                    }
                }
                if (isset($params) && isset($params['access'])) {
                    if (Auth::check()) {
                        $q = $q->where('content_restriction', '<>', Article::RESTRICTION_PAY);
                    } else {
                        $q = $q->where('content_restriction', '=', Article::RESTRICTION_NO);
                    }
                }
                break;
        }

        if (isset($params)) {
            $q = $q->leftJoin('article_author', 'article_author.article_id', '=', 'articles.id')
                ->leftJoin('authors', 'article_author.author_id', '=', 'authors.id')
                ->leftJoin('journal_category', 'journal_category.journal_id', '=', 'journals.id')
                ->leftJoin('article_category', 'article_category.article_id', '=', 'articles.id')
                ->leftJoin('categories as journal_categories', 'journal_categories.id', '=', 'journal_category.category_id')
                ->leftJoin('categories as article_categories', 'article_categories.id', '=', 'article_category.category_id')
                ->leftJoin('journal_translations', 'journals.id', '=', 'journal_translations.journal_id')
                ->leftJoin('release_translations', 'releases.id', '=', 'release_translations.release_id')
                ->leftJoin('article_translations', 'articles.id', '=', 'article_translations.article_id')
                ->leftJoin('author_translations', 'authors.id', '=', 'author_translations.author_id');

            if (isset($params['q']) && $params['q']) {
                if ($params['type'] == UserSearch::TYPE_JOURNAL) {
                    $q = $q->where('journal_translations.name', 'like', '%' . $params['q'] . '%');
                } else {
                    $q = $q->where(function ($query) use ($params) {
                        $query->where('article_translations.name', 'like', '%' . $params['q'] . '%')
                            ->orWhere('release_translations.name', 'like', '%' . $params['q'] . '%')
                            ->orWhere('article_translations.description', 'like', '%' . $params['q'] . '%');
                    });
                }
            }
            if (isset($params['category']) && $params['category']) {
                $q = $q->where(function ($query) use ($params) {
                    $query->where('journal_categories.id', '=', $params['category'])
                        ->orWhere('article_categories.id', '=', $params['category']);
                });
            }
//            if (isset($params['journal']) && $params['journal']) {
//                $q = $q->where(function ($query) use ($params) {
//                    $query->where('article_translations.name', 'like', '%' . $params['q'] . '%')
//                        ->orWhere('release_translations.name', 'like', '%' . $params['q'] . '%')
//                        ->orWhere('article_translations.description', 'like', '%' . $params['q'] . '%');
//                });
//            }
            if (isset($params['category']) && $params['category']) {
                if ($params['type'] == UserSearch::TYPE_JOURNAL) {
                    $q = $q->where('journal_categories.id', '=', $params['category']);
                } else {
                    $q = $q->where('article_categories.id', '=', $params['category']);
                }
            }
            if (isset($params['journal']) && $params['journal']) {
                $q = $q->where('journals.id', '=', $params['journal']);
            }
            if (isset($params['author_char']) && $params['author_char']) {
                $q = $q->where('author_translations.name', 'like', $params['author_char'] . '%');
            }
            if (isset($params['author'])) {
                $q = $q->where('author_translations.name', '=', $params['author']);
            }
            if (isset($params['active_from']) && $params['active_from']) {
                $q = $q->where('articles.active_date', '<', $params['active_from']);
            }
            if (isset($params['active_to']) && $params['active_to']) {
                $q = $q->where('articles.active_end_date', '>', $params['active_to']);
            }
            if (isset($params['udk']) && $params['udk']) {
                $q = $q->where('articles.UDC', 'like', '%' . $params['udk'] . '%');
            }

            if (isset($params['sort_by'])) {
                switch ($params['sort_by']) {
                    case 'name':
                        if ($params['type'] == 'journal') {
                            $orderBy = 'journalName';
                        } else {
                            $orderBy = 'articleName';
                        }
                        $q = $q->orderBy($orderBy, isset($params['sort_order']) ? $params['sort_order'] : 'asc');
                        break;
                    case 'date':
                        if ($params['type'] == 'journal') {
                            $orderBy = 'journalActiveDate';
                        } else {
                            $orderBy = 'articleActiveDate';
                        }
                        $q = $q->orderBy($orderBy, isset($params['sort_order']) ? $params['sort_order'] : 'asc');
                        break;
                }
            }

            // Translations + activity
            if ($params['type'] == UserSearch::TYPE_JOURNAL) {
                $q = $q->where('journal_translations.locale', '=', $searchLocale)
                    ->where('journals.active', '=', 1);
            } else {
                $q = $q->where('article_translations.locale', '=', $searchLocale)
                    ->where('articles.active', '=', 1);
            }

            return $q->groupBy($groupBy);
        } else {
            return false;
        }
    }
}
