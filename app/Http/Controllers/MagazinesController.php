<?php

namespace App\Http\Controllers;

use App\Author;
use App\Category;
use App\Journal;
use App\Release;
use Illuminate\Http\Request;

class MagazinesController extends Controller
{
    public function __invoke(Request $request)
    {
        if ($request->get('sort_by')) {
            $journals = Journal::where('active', 1)
                ->orderBy($request->get('sort_by'), $request->get('sort_order'))
                ->paginate(10);
        } else {
            $journals = Journal::paginate(10);
        }
        $categories = Category::with('journals')->get();
        $authorAlphabet = Author::getAlphabet();
        $lastReleases = Release::allNew()->limit('4')->get();

        return view('magazines.index', compact(
            'journals',
            'categories',
            'authorAlphabet',
            'lastReleases'
        ));
    }
}
