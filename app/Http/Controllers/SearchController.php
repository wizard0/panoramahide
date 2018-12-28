<?php

namespace App\Http\Controllers;

use App\Article;
use App\UserSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $extend = $request->get('extend');

        $params = $request->all();
        if ($params && (isset($params['search']) || isset($params['q']))) {
            Cookie::queue('search_params', json_encode($params));
        } else {
            $params = json_decode(Cookie::get('search_params'), true);
        }
        if (!isset($params['sort_by']) && $request->has('sort_by')) {
            $params['sort_by'] = $request->get('sort_by');
            $params['sort_order'] = $request->get('sort_order');
//            array_push($params, $request->only(['sort_by', 'sort_order']));
        }

        $searchResult = $this->search($params);
        if ($searchResult) {
//            $rowCount = $searchResult->count();
            $search = $searchResult->paginate(10);
            $rowCount = $search->total();
            foreach ($search as $s) {
                if (property_exists($s, 'found')) {
                    $found = $this->getFoundString($request->get('q'), $s->found);
                    if ($found) {
                        $s->found = $found[0];
                        $s->length = sizeof($found);
                    }
                }
            }
        } else {
            $search = [];
        }

        return view('search.index', compact('search', 'extend', 'rowCount', 'params'));
    }

    private function search($params)
    {
        $groupBy = 'articles.code';
        if (!isset($params['type'])) $params['type'] = 'any';
            switch ($params['type']) {
                case 'journal':
                    $groupBy = 'journals.code';
                    $q = DB::table('journals')
                        ->selectRaw("
                            ANY_VALUE(journals.id) as journalID,
                            ANY_VALUE(journals.image) as journalImage,
                            ANY_VALUE(journals.active_date) as journalActiveDate,
                            ANY_VALUE(articles.name) as articleName,
                            ANY_VALUE(articles.id) as articleID,
                            ANY_VALUE(articles.code) as articleCode,
                            ANY_VALUE(articles.description) as articleDescr,
                            ANY_VALUE(journals.issn) as journalISSN,
                            ANY_VALUE(releases.id) as releaseID,
                            ANY_VALUE(releases.name) as releaseName,
                            ANY_VALUE(authors.name) as authorName,
                            ANY_VALUE(authors.id) as authorID,
                            ANY_VALUE(journals.name) as journalName,
                            ANY_VALUE(journals.code) as journalCode,
                            ANY_VALUE(releases.name) as releaseName,
                            ANY_VALUE(releases.code) as releaseCode"
                        )
                        ->leftJoin('releases', 'releases.journal_id', '=', 'journals.id')
                        ->leftJoin('articles', 'releases.id', '=', 'articles.release_id');
                    break;
                default:
                    if (isset($params['q']) && $params['q']) {
                        $q = Db::table('articles')
                            ->selectRaw("
                                ANY_VALUE(articles.name) as articleName,
                                ANY_VALUE(articles.id) as articleID,
                                ANY_VALUE(articles.code) as articleCode,
                                ANY_VALUE(articles.description) as articleDescr,
                                ANY_VALUE(releases.name) as releaseName,
                                ANY_VALUE(authors.name) as authorName,
                                ANY_VALUE(authors.id) as authorID,
                                ANY_VALUE(journals.name) as journalName,
                                ANY_VALUE(journals.code) as journalCode,
                                ANY_VALUE(releases.name) as releaseName,
                                ANY_VALUE(releases.code) as releaseCode,
                                ANY_VALUE(articles.active_date) as articleActiveDate,
                                CASE
                                    WHEN ANY_VALUE(articles.description) like '%{$params['q']}%'
                                      THEN ANY_VALUE(articles.description)
                                      ELSE null
                                END as found
                            ");
                    } else {
                        $q = Db::table('articles')
                            ->selectRaw("
                                ANY_VALUE(articles.name) as articleName,
                                ANY_VALUE(articles.id) as articleID,
                                ANY_VALUE(articles.code) as articleCode,
                                ANY_VALUE(articles.description) as articleDescr,
                                ANY_VALUE(releases.name) as releaseName,
                                ANY_VALUE(authors.name) as authorName,
                                ANY_VALUE(authors.id) as authorID,
                                ANY_VALUE(journals.name) as journalName,
                                ANY_VALUE(journals.code) as journalCode,
                                ANY_VALUE(releases.name) as releaseName,
                                ANY_VALUE(releases.code) as releaseCode,
                                ANY_VALUE(articles.active_date) as articleActiveDate
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
                            $q = $q->where('articles.content_restriction', '<>', Article::RESTRICTION_PAY);
                        } else {
                            $q = $q->where('articles.content_restriction', '=', Article::RESTRICTION_NO);
                        }
                    }
                    break;
            }
        if (isset($q) && isset($params)) {
            $q = $q->leftJoin('article_author', 'article_author.article_id', '=', 'articles.id')
                ->leftJoin('authors', 'article_author.author_id', '=', 'authors.id')
                ->leftJoin('journal_category', 'journal_category.journal_id', '=', 'journals.id')
                ->leftJoin('categories', 'categories.id', '=', 'journal_category.category_id');

            if (isset($params['q']) && $params['q']) {
                $q = $q->where(function ($query) use ($params) {
                    $query->where('articles.name', 'like', '%' . $params['q'] . '%')
                        ->orWhere('releases.name', 'like', '%' . $params['q'] . '%')
                        ->orWhere('articles.description', 'like', '%' . $params['q'] . '%');
                });
            }
            if (isset($params['category']) && $params['category'])
                $q = $q->where('categories.id', '=', $params['category']);
            if (isset($params['journal']) && $params['journal'])
                $q = $q->where('journals.id', '=', $params['journal']);
            if (isset($params['author_char']) && $params['author_char'])
                $q = $q->where('authors.name', 'like', $params['author_char'] . '%');
            if (isset($params['active_from']) && $params['active_from'])
                $q = $q->where('articles.active_date', '<', $params['active_from']);
            if (isset($params['active_to']) && $params['active_to'])
                $q = $q->where('articles.active_end_date', '>', $params['active_to']);
            if (isset($params['udk']) && $params['udk'])
                $q = $q->where('articles.UDC', 'like', '%'.$params['udk'].'%');

            if (isset($params['sort_by'])) {
                switch ($params['sort_by']) {
                    case 'name':
                        if ($params['type'] == 'journal') $orderBy = 'journalName';
                        else $orderBy = 'articleName';
                        $q = $q->orderBy(
                            $orderBy,
                            isset($params['sort_order']) ? $params['sort_order'] : 'asc'
                        );
                        break;
                    case 'date':
                        if ($params['type'] == 'journal') $orderBy = 'journalActiveDate';
                        else $orderBy = 'articleActiveDate';
                        $q = $q->orderBy(
                            $orderBy,
                            isset($params['sort_order']) ? $params['sort_order'] : 'asc'
                        );
                        break;
                }
            }

            return $q->groupBy($groupBy);
        }
    }

    /**
     * @param $seek
     * @param $found
     *
     * @return string|null sentences from article where query word (q) was found
     */
    private function getFoundString($seek, $found)
    {
        $seek = strtolower($seek);
        preg_match_all("/[a-z ]*{$seek}[a-z ]*\./i", $found, $matches);
        return $matches[0];
    }

    public function saveSearch(Request $request)
    {
        $userSearch = new UserSearch();
        $userSearch->user_id = Auth::id();
        $userSearch->search_params = json_encode($request->get('data'));
        $userSearch->save();

        return json_encode(['success' => true, 'ID' => $userSearch->id]);
    }

    public function deleteSearch(Request $request)
    {
        $id = $request->get('id');
        $ids = [];
        if ($id == 'all') {
            Auth::user()->searches()->each(function ($item, $key) {
                $item->delete();
                $ids[] = $item->id;
            });
            Cookie::forget('search_params');
        } else {
            UserSearch::where('id', $id)->delete();
            $ids[] = $id;
        }

        return json_encode(['success' => true, 'ids' => $ids]);
    }
}
