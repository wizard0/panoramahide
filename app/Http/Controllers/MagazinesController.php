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
        $journals = Journal::getSome($request->all());
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
