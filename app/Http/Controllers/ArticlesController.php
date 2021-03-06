<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function detail(Request $request, $code)
    {
        $article = Article::whereTranslationCode($code)->first();
        $release = $article->release;
        $journal = $release->journal;

        return view('article.detail.index', compact('article', 'release', 'journal'));
    }
}
