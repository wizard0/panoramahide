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

    public function detail(Request $request)
    {
        return view('magazines.detail.index');
    }
}
