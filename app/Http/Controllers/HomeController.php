<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Services\PromocodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function journals()
    {
        $oPromoUser = Auth::user()->promo;

        $oPromocodes = $oPromoUser->promocodes;

        if (count($oPromocodes) !== 0) {
            $service = new PromocodeService();
            $oPromocodes = $oPromocodes->transform(function ($item) use ($service, $oPromoUser) {
                $item->journals = $service->setPromocode($item)
                    ->setPromoUser($oPromoUser)
                    ->getJournals();
                return $item;
            });
        }

        return view('home.journals', [
            'oPromocodes' => $oPromocodes
        ]);
        return view('home.journals');
    }
}
