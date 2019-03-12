<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function __invoke(Request $request)
    {
        $categories = Category::where('active', 1)->withTranslation()->get();

        return view('categories.index', compact('categories'));
    }
}
