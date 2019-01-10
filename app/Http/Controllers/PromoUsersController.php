<?php

namespace App\Http\Controllers;

use App\Models\PromoUser;
use App\Promocode;
use App\Release;
use App\Services\PromoUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PromoUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $validator = Validator::make($data, [
                'name' => ['required', 'max:255'],
                'user_id' => ['required'],
                'phone' => ['required', 'string', Rule::unique('promo_users', 'phone')],
            ]);
            if ($validator->fails()) {
                return $this->jsonResponseValidationErrors($validator->getMessageBag()->toArray());
            }
            PromoUser::create([
                'name' => $data['name'],
                'user_id' => $data['user_id'],
                'phone' => $data['phone'],
            ]);
        };
        return responseCommon()->mustBeAjax();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $validator = Validator::make($data, [
                'name' => ['required', 'max:255'],
                'phone' => ['required', 'string', Rule::unique('promo_users', 'phone')],
            ]);
            if ($validator->fails()) {
                return $this->jsonResponseValidationErrors($validator->getMessageBag()->toArray());
            }
            $oPromoUser = PromoUser::find($id);
            $oPromoUser->update([
                'name' => $data['name'],
                'phone' => $data['phone'],
            ]);
        };
        return responseCommon()->mustBeAjax();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $oPromoUser = PromoUser::find($id);
            $oPromoUser->delete();
        };
        return responseCommon()->mustBeAjax();
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function promocodes(Request $request, $id)
    {
        $oPromoUser = PromoUser::with('promocodes')->find($id);
        $oPromocodesActive = $oPromoUser->promocodes;

        $now = now();
        $oPromocodesAvailable = Promocode::where('active', 1)
            ->where('release_begin', '<=', $now->startOfDay())
            ->where('release_end', '>=', $now->endOfDay())
            ->get();

        return view('home', [
            'oPromoUser' => $oPromoUser,
            'oPromocodesActive' => $oPromocodesActive,
            'oPromocodesAvailable' => $oPromocodesAvailable,
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @param $item_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function activatePromocode(Request $request, $id, $item_id)
    {
        if ($request->ajax()) {
            $oPromoUser = PromoUser::find($id);
            $oPromoCode = Promocode::find($item_id);
            $service = (new PromoUserService($oPromoUser));
            if (!$service->activatePromocode($oPromoCode)) {
                return $this->jsonResponseValidationErrors([$service->getMessage()]);
            }
        };
        return responseCommon()->mustBeAjax();
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function publishings(Request $request, $id)
    {
        $oPromoUser = PromoUser::with('publishings')->find($id);
        $oPublishingsActive = $oPromoUser->publishings;

        $oPublishingsAvailable = Release::where('active', 1)->get();

        return view('home', [
            'oPromoUser' => $oPromoUser,
            'oPublishingsActive' => $oPublishingsActive,
            'oPublishingsAvailable' => $oPublishingsAvailable,
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @param $item_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function activatePublishing(Request $request, $id, $item_id)
    {
        if ($request->ajax()) {
            $oPromoUser = PromoUser::find($id);
        };
        return responseCommon()->mustBeAjax();
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function releases(Request $request, $id)
    {
        $oPromoUser = PromoUser::with('releases')->find($id);
        $oReleasesActive = $oPromoUser->releases;

        $oReleasesAvailable = Release::where('active', 1)->get();

        return view('home', [
            'oPromoUser' => $oPromoUser,
            'oReleasesActive' => $oReleasesActive,
            'oReleasesAvailable' => $oReleasesAvailable,
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @param $item_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function activateRelease(Request $request, $id, $item_id)
    {
        if ($request->ajax()) {
            $oPromoUser = PromoUser::find($id);
        };
        return responseCommon()->mustBeAjax();
    }



}
