<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index()
    {
        return view('promo');
    }

    public function access(Request $request)
    {
        return response()->json([
            'success' => true,
            'result' => 1,
            'data' => $request->all()
        ]);
    }

    public function code(Request $request)
    {

    }

}
