<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Category;
use App\Models\Journal;
use App\Models\JournalSentArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

/**
 * Controls the data flow into magazines object and updates the view whenever data changes.
 */
class MagazinesController extends Controller
{
    const ITEMS_PER_PAGE = 10;

    public function __invoke(Request $request)
    {
        $journals = Journal::getSome($request->all());
//        $journals->load('releases');
//        $categories = Category::with('journals')->withTranslation()->get();
        $authorAlphabet = Author::getAlphabet();

        return view('magazines.index', compact('journals', 'authorAlphabet'));
    }

    /* TODO. Maybe need smth like this
     * if (!$journal->active)
     *     return response('You cannot', 401);
     *
     */
    public function detail(Request $request, $code)
    {
        $journal = Journal::whereTranslationCode($code)->first();

        return view('magazines.detail.index', compact('journal'));
    }

    public function ajaxGetPage(Request $request)
    {
        if ($request->ajax()) {
            $code = $request->get('code');
            $journal = Journal::whereTranslationCode($code)->first();

            $tab = $request->get('tab');
            switch ($tab) {
                case 'magazine':
                    return view('magazines.detail.tab_journal', compact('journal'));
                case 'numbers':
                    $releases = $journal->getReleasesByYears();
                    return view('magazines.detail.tab_releases', compact('journal', 'releases'));
                case 'fresh_number':
                    $articles = $journal->getArticlesFresh(self::ITEMS_PER_PAGE);
//                    dd($journal);
                    $articles->withPath(route('journal', ['code' => $journal->code])); // For paginate links
                    return view('magazines.detail.tab_articles', compact('journal', 'articles', 'tab'));
                case 'articles':
                    $articles = $journal->getArticlesAll(self::ITEMS_PER_PAGE);
                    $articles->withPath(route('journal', ['code' => $journal->code])); // For paginate links
                    return view('magazines.detail.tab_articles', compact('journal', 'articles', 'tab'));
                case 'subscribe':
                    $subscriptions = $journal->getSubscribeInfo();
                    return view('magazines.detail.tab_subscribe', compact('journal', 'subscriptions'));
                case 'send_article':
                    return view('magazines.detail.tab_send_article', compact('journal'));
                case 'info':
                    return view('magazines.detail.tab_info', compact('journal'));
            }
        } else {
            return Redirect::back();
        }
    }

    public function sendArticle(Request $request)
    {
        $store = new JournalSentArticle($request->only(['name', 'email', 'message']));
        $store->journal_id = $request->get('journal');
        $store->file = $request->file('files')
            ->store('journal_sent_articles/' . $request->get('journal'));
        if (Auth::check()) {
            $store->user_id = Auth::id();
        }
        $store->save();

//        $request->session()->flash('status', __('Article sent'));
        return Redirect::back();
    }
}
