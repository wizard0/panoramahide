<?php

namespace App\Http\Controllers;

use App\Journal;
use App\Mail\Recommend;
use App\UserFavorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AjaxActionsController extends Controller
{
    public function recommendJournal(Request $request)
    {
        $emailFrom = $request->get('email_from');
        $emailTo = $request->get('email_to');
        $journalIds = explode(',', $request->get('ids'));
        $links = [];
        foreach ($journalIds as $id) {
            if (is_numeric($id))
                $links[] = Journal::where('id', $id)->first()->getLink();
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
