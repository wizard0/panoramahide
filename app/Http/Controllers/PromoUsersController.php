<?php
/**
 * Copyright (c) 2018-2019 "ИД Панорама"
 * Автор модуля: Дмитрий Поскачей (dposkachei@gmail.com)
 */

namespace App\Http\Controllers;

use App\Models\Promocode;
use App\Models\PromoUser;
use App\Models\Release;
use App\Services\PromoUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PromoUsersController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
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
                return responseCommon()->validationMessages($validator);
            }
            PromoUser::create([
                'name' => $data['name'],
                'user_id' => $data['user_id'],
                'phone' => $data['phone'],
            ]);
            return responseCommon()->success();
        };
        return responseCommon()->mustBeAjax();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
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
                return responseCommon()->validationMessages($validator);
            }
            $oPromoUser = PromoUser::find($id);
            $oPromoUser->update([
                'name' => $data['name'],
                'phone' => $data['phone'],
            ]);
            return responseCommon()->success();
        };
        return responseCommon()->mustBeAjax();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $oPromoUser = PromoUser::find($id);
            $oPromoUser->delete();
            return responseCommon()->success();
        };
        return responseCommon()->mustBeAjax();
    }

    /**
     * @param Request $request
     * @param integer $id
     * @return \Illuminate\View\View
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
     * @param integer $id
     * @param integer $item_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function activatePromocode(Request $request, $id, $item_id)
    {
        if ($request->ajax()) {
            $oPromoUser = PromoUser::find($id);
            $oPromoCode = Promocode::find($item_id);
            $service = (new PromoUserService($oPromoUser));
            if (!$service->activatePromocode($oPromoCode)) {
                return responseCommon()->validationMessages(null, [$service->getMessage()]);
            }
            return responseCommon()->success();
        };
        return responseCommon()->mustBeAjax();
    }

    /**
     * @param Request $request
     * @param integer $id
     * @return \Illuminate\View\View
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
     * @param int $id
     * @param int $item_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function activatePublishing(Request $request, $id, $item_id)
    {
        if ($request->ajax()) {
            $oPromoUser = PromoUser::find($id);
            return responseCommon()->success();
        };
        return responseCommon()->mustBeAjax();
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\View\View
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
     * @param int $id
     * @param int $item_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function activateRelease(Request $request, $id, $item_id)
    {
        if ($request->ajax()) {
            $oPromoUser = PromoUser::find($id);
            return responseCommon()->success();
        };
        return responseCommon()->mustBeAjax();
    }
}
