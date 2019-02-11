<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class ReaderController extends Controller
{
    public function index()
    {
        return view('reader.index');
    }
}
