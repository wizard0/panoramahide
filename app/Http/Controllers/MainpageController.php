<?php

namespace App\Http\Controllers;

use App\Category;
use App\Journal;
use App\News;
use App\Release;
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

        return view('mainpage', compact(
            'lastReleases',
            'lastNews',
            'journalCategories'
        ));
    }
}
