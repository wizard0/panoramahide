<?php

namespace App\Http\Controllers;

use App\Order;
use App\Release;
use App\Services\ReaderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ReaderController extends Controller
{
    public function index(Request $request)
    {
        $oRelease = !$request->exists('release_id') ? Release::first() : Release::where('id', $request->exists('get'))->first();

        list($oJournal, $oArticles) = (new ReaderService())->byRelease($oRelease)->data();

        $oArticles = $oArticles->transform(function ($item) {

            $file = resource_path('views/reader/html/article_00'.sprintf("%02d", $item->id).'.html');
            $item->html = File::exists($file) ? file_get_contents($file) : '';
            return $item;
        });

        $oRelease->cover = asset('img/covers/befc001381c5d89ccf4e3d3cd6c95cf0.png');

        return view('reader.index', [
            'oRelease' => $oRelease,
            'oJournal' => $oJournal,
            'oArticles' => $oArticles,
        ]);
    }
}
