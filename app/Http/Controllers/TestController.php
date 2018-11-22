<?php

namespace App\Http\Controllers;

use App\Article;
use App\Category;
use App\Journal;
use App\Language;
use App\Publishing;
use App\Translate\JournalTranslate;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function __invoke()
    {
        $article = Publishing::all();
    }
}
