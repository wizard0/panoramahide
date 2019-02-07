<?php

namespace App\Http\Controllers;

use App\Order;
use App\Release;
use App\Services\ReaderService;
use Illuminate\Http\Request;

class ReaderController extends Controller
{
    public function index()
    {
        list($oJournal) = (new ReaderService())->byRelease(Release::first())->data();

        return view('reader.index', [
            'oJournal' => $oJournal
        ]);
    }
}
