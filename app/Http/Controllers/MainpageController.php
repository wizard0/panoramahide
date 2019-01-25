<?php

namespace App\Http\Controllers;

use App\Category;
use App\Journal;
use App\Models\Promocode;
use App\News;
use App\Release;
use App\Services\PromocodeService;
use Illuminate\Http\Request;
use App\Cart;
use Session;

class MainpageController extends Controller
{
    public function index()
    {
        $lastReleases = Release::allNew()->limit(4)->get();
        $lastNews = News::allNew()->limit(5)->get();
        $journalCategories = Category::has('journals')->get();


        //$oService = new PromocodeService();
        //dd(Promocode::find(1)->journals);
        //$oService = new PromocodeService(Promocode::find(1));

        //dd($oService->getReleases());

        return view('mainpage', compact(
            'lastReleases',
            'lastNews',
            'journalCategories'
        ));
    }
}
