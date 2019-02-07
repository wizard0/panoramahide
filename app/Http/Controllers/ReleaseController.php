<?php

namespace App\Http\Controllers;

use App\Release;
use Illuminate\Http\Request;

class ReleaseController extends Controller
{
    public function detail(Request $request, $journalCode, $releaseID)
    {
        $release = Release::where('id', $releaseID)->withTranslation()->first();
        $journal = $release->journal->load('translations');
        $articles = $release->articles->load('translations');

        return view('release.detail.index', compact('release', 'journal', 'articles'));
    }
}
