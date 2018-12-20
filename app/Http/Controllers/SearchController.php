<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $extend = $request->get('extend');

        $search = $this->search($request->all());

        return view('search.index');
    }

    private function search($params)
    {

        if (isset($params['type']))
        switch ($params['type']) {
            case 'article':
                $q = Db::table('articles')
                    ->select()
                    ->join('releases', 'articles.releases_id', '=', 'releases.id')
                    ->join('article_author', 'article_author.article_id', '=', 'articles.id')
                    ->join('authors', 'article_author.author_id', '=', 'authors.id')
                    ->join('journals', 'releases.journal_id', '=', 'journals.id')
                    ->join('article_category', 'article_category.article_id', '=', 'articles.id')
                    ->join('categories', 'categories.id', '=', 'article_category.category_id')
                    ->where(function ($query) {
                        $query->where('articles.name', 'like', '%' . $params['q'] . '%')
                            ->orWhere('releases.name', 'like', '%' . $params['q'] . '%');
                    })
                    ->where('category.id', '=', $params['category'])
                    ->where('journal.id', '=', $params['journal'])
                    ->where('author.name', 'like', $params['author_char'] . '%');
                break;
        }

    }
}
