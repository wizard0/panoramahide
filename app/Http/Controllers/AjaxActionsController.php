<?php

namespace App\Http\Controllers;

use App\Article;
use App\Journal;
use App\Mail\Recommend;
use App\UserFavorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AjaxActionsController extends Controller
{
    public function recommend(Request $request)
    {
        $emailFrom = $request->get('email_from');
        $emailTo = $request->get('email_to');
        $r = json_decode($request->get('ids'));
        $links = [];
        foreach ($r as $data) {
            if (is_numeric($data->id))
                if ($data->type == 'journal')
                    $links[] = Journal::where('id', $data->id)->first()->getLink();
                if ($data->type == 'article')
                    $links[] = Article::where('id', $data->id)->first()->getLink();
        }

        Mail::to($emailTo)->send(new Recommend($emailFrom, $links));
    }

    public function addToFavorite(Request $request)
    {
        $data = json_decode($request->get('data'));

        foreach ($data as $dataRow) {
            $fav = new UserFavorite();
            $fav->user_id = Auth::user()->id;
            $fav->element_id = $dataRow->id;
            $fav->type = $dataRow->type;
            $fav->save();
        }
    }
}
