<?php

namespace App\Http\Controllers;

use App\Journal;
use App\Publishing;
use Illuminate\Http\Request;

class PublishersController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $publishers = Publishing::withTranslation()->get();

        return view('publishers.index', compact('publishers'));
    }

    public function detail(Request $request, $code)
    {
        $publisher = Publishing::whereTranslation('code', $code)->first();
        $journals = $publisher->journals;

        if ($request->has('sort_by')) {
            $order = $request->has('order_by') ? $request->get('order_by') : 'asc';
            switch ($request->get('sort_by')) {
                case 'name':
                    $journals = Journal::whereHas('publishings', function ($query) use ($publisher) {
                        $query->where('publishing_id', $publisher->id);
                    })->orderByTranslation('name', $order)->get();
                    break;
                case 'date':
                    if ($order != 'asc')
                        $journals = $journals->sortByDesc('active_date');
                    else
                        $journals = $journals->sortBy('active_date');
                    break;
            }
        }

        $journals = $journals->load('translations');

        return view('publishers.detail.index', compact('publisher', 'journals'));
    }
}
