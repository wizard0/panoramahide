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
        $lastNews = News::allNew()->withTranslation()->limit(5)->get();
        $journalCategories = Category::has('journals')->withTranslation()->get();

        return view('mainpage', compact(
            'lastNews',
            'journalCategories'
        ));
    }
}
