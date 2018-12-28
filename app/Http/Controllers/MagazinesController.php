<?php

namespace App\Http\Controllers;

use App\Author;
use App\Category;
use App\Journal;
use App\Release;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class MagazinesController extends Controller
{
    public function __invoke(Request $request)
    {
        if (
            $request->has('sort_by') &&
            Schema::hasColumn('journals', $request->get('sort_by'))
        ) {
            $order = $request->has('sort_order') ? $request->get('sort_order') : 'asc';
            $journals = Journal::where('active', 1)
                ->orderBy($request->get('sort_by'), $order)
                ->paginate(10);
        } else {
            $journals = Journal::where('active', 1)->orderBy('name', 'asc')->paginate(10);
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
