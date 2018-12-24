<?php

namespace App\Http\Controllers;

use App\UserSearch;
use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $extend = $request->get('extend');

        $searchResult = $this->search($request->all());
        if ($searchResult) {
            $search = $searchResult->paginate(10);
            $rowCount = $searchResult->count();
            foreach ($search as $s) {
                $found = $this->getFoundString($request->get('q'), $s->found);
                if ($found) {
                    $s->found = $found[0];
                    $s->length = sizeof($found);
                }
            }
        } else {
            $search = [];
        }

        return view('search.index', compact('search', 'extend', 'rowCount'));
    }

    private function search($params)
    {
        if (isset($params['q']))
            switch ($params['type']) {
                case 'journal':
                    $q = DB::table('journals')
                        ->select()
                        ->leftJoin('releases', 'releases.journal.id', '=', 'journals.id')
                        ->leftJoin('articles', 'releases.id', '=', 'articles.journal_id');
                    break;
                default:
                    $q = Db::table('articles')
                        ->selectRaw("
                            articles.name as articleName,
                            articles.id as articleID,
                            articles.code as articleCode,
                            articles.description as articleDescr,
                            releases.name as releaseName,
                            authors.name as authorName,
                            authors.id as authorID,
                            journals.name as journalName,
                            journals.code as journalCode,
                            releases.name as releaseName,
                            releases.code as releaseCode,
                            CASE
                                WHEN articles.description like '%{$params['q']}%'
                                  THEN articles.description
                                  ELSE null
                            END as found
                        ")
                        ->leftJoin('releases', 'articles.release_id', '=', 'releases.id')
                        ->leftJoin('journals', 'releases.journal_id', '=', 'journals.id');
                    break;
            }
        if (isset($q) && isset($params)) {
            $q = $q->leftJoin('article_author', 'article_author.article_id', '=', 'articles.id')
                ->leftJoin('authors', 'article_author.author_id', '=', 'authors.id')
                ->leftJoin('article_category', 'article_category.article_id', '=', 'articles.id')
                ->leftJoin('categories', 'categories.id', '=', 'article_category.category_id')
                ->where(function ($query) use ($params) {
                    $query->where('articles.name', 'like', '%' . $params['q'] . '%')
                        ->orWhere('releases.name', 'like', '%' . $params['q'] . '%')
                        ->orWhere('articles.description', 'like', '%' . $params['q'] . '%');
                });
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

            return $q;
        }
    }

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
        if ($id = 'all') {
            Auth::user()->searches()->each(function ($item, $key) {
                $item->delete();
                $ids[] = $item->id;
            });
        } else {
            UserSearch::where('id', $id)->delete();
            $ids[] = $id;
        }

        return json_encode(['success' => true, 'ids' => $ids]);
    }
}
