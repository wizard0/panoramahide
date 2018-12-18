<?php

namespace App\Http\Controllers;

use App\Journal;
use App\Mail\Recommend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AjaxActionsController extends Controller
{
    public function recommendJournal(Request $request) {
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
}
