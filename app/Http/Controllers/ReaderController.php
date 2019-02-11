<?php

namespace App\Http\Controllers;

use App\Order;
use App\Release;
use App\Services\ReaderService;
use Illuminate\Http\Request;

class ReaderController extends Controller
{
    public function index(Request $request)
    {
        $oRelease = !$request->exists('release_id') ? Release::first() : Release::where('id', $request->get('release_id'))->first();

        $oService = (new ReaderService())->byRelease($oRelease);

        $oJournal = $oService->getJournal();
        $oArticles = $oService->getArticles();
        $oReleases = $oService->getReleases();

        $oRelease->image = asset('img/covers/befc001381c5d89ccf4e3d3cd6c95cf0.png');

        return view('reader.index', [
            'oRelease' => $oRelease,
            'oReleases' => $oReleases,
            'oJournal' => $oJournal,
            'oArticles' => $oArticles,
        ]);
    }
}
