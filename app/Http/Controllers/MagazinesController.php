<?php

namespace App\Http\Controllers;

use App\Author;
use App\Category;
use App\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MagazinesController extends Controller
{
    const ITEMS_PER_PAGE = 10;

    public function __invoke(Request $request)
    {
        $journals = Journal::getSome($request->all());
        $journals->load('releases');
        $categories = Category::with('journals')->withTranslation()->get();
        $authorAlphabet = Author::getAlphabet();

        return view('magazines.index', compact(
            'journals',
            'categories',
            'authorAlphabet'
        ));
    }

    public function detail(Request $request, $code)
    {
        $journal = Journal::whereTranslation('code', $code)->first();

        return view('magazines.detail.index', compact('journal'));
    }

    public function ajaxGetPage(Request $request)
    {
        if ($request->ajax()) {
            $code = $request->get('code');
            $journal = Journal::whereTranslation('code', $code)->first();

            $tab = $request->get('tab');
            switch ($tab) {
                case 'magazine':
                    return view('magazines.detail.tab_journal', compact('journal'));
                case 'numbers':
                    $releases = $journal->getReleasesByYears();
                    return view('magazines.detail.tab_releases', compact('journal', 'releases'));
                case 'fresh_number':
                    $articles = $journal->getArticlesFresh(self::ITEMS_PER_PAGE);
                    $articles->withPath(route('journal', ['code' => $journal->code])); // For paginate links
                    return view('magazines.detail.tab_articles', compact('journal', 'articles', 'tab'));
                case 'articles':
                    $articles = $journal->getArticlesAll(self::ITEMS_PER_PAGE);
                    $articles->withPath(route('journal', ['code' => $journal->code])); // For paginate links
                    return view('magazines.detail.tab_articles', compact('journal', 'articles', 'tab'));
                case 'subscribe':
                    $subscriptions = $journal->getSubscriptionsByTypes();
                    return view('magazines.detail.tab_subscribe', compact('journal', 'subscriptions'));
            }
        } else {
            return Redirect::back();
        }
    }
}
