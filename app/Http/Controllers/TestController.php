<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Journal;
use App\Models\Language;
use App\Models\Publishing;
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
