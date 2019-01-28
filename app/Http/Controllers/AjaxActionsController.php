<?php

namespace App\Http\Controllers;

use App\Article;
use App\Journal;
use App\Mail\Recommend;
use App\UserFavorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use PDF;
use View;

class AjaxActionsController extends Controller
{
    public function recommend(Request $request)
    {
        $emailFrom = $request->get('email_from');
        $emailTo = $request->get('email_to');
        $r = json_decode($request->get('ids'), true);
        $links = [];
        foreach ($r as $data) {
            if (is_numeric($data['id']))
                if ($data['type'] == 'journal')
                    $links[] = Journal::where('id', $data['id'])->first()->getLink();
                if ($data['type'] == 'article')
                    $links[] = Article::where('id', $data['id'])->first()->getLink();
        }

        Mail::to($emailTo)->send(new Recommend($emailFrom, $links));
    }

    public function addToFavorite(Request $request)
    {
        $data = $request->get('data');
        if (!is_array($data))
            $data = json_decode($data, true);

        foreach ($data as $dataRow) {
            $fav = new UserFavorite();
            $fav->user_id = Auth::user()->id;
            $fav->element_id = $dataRow['id'];
            $fav->type = $dataRow['type'];
            $fav->save();
        }
    }

    public function printAbonement(Request $request)
    {
        $requestData = $request->all();
        $abonementStartMonth = (date('d') < 20
            ? date('n', strtotime('+1 month'))
            : date('n', strtotime('+2 month')));
        $abonementID = $requestData['provider'] == 'ROSP'
            ? $requestData['index_rospechat']
            : $requestData['index_pochta'];
        $journalName = $requestData['element_name'];
        $title = $requestData['provider'] == 'ROSP'
            ? "Агентство &laquo;Роспечать&raquo;"
            : "«Межрегиональное агентство подписки» (МАП)";
        $catalog = $requestData['provider'] == 'ROSP'
            ? "агентства &laquo;Роспечать&raquo;"
            : "российской прессы";
        $count = $requestData['rospechat_count'];
        $userIndex = $requestData['rospechat_index'];
        $userName = $requestData['rospechat_fio'];
        $userAddr = $requestData['rospechat_address'];

        if (array_key_exists('rospachat_form_button_pdf', $requestData)) {
            // this means that user wanna to get PDF

            $pdf = PDF::loadHTML(View::make('print.abonement', compact(
                'abonementStartMonth',
                'abonementID',
                'journalName',
                'title',
                'catalog',
                'count',
                'userIndex',
                'userName',
                'userAddr'
            ))->render())->setPaper('A4', 'portrait');

            return $pdf->download('abonement.pdf');
        } else {
            // user just wanna to print it

            return view('print.abonement', compact(
                'abonementStartMonth',
                'abonementID',
                'journalName',
                'title',
                'catalog',
                'count',
                'userIndex',
                'userName',
                'userAddr'
            ));
        }

    }
}
