<?php

namespace App\Http\Controllers;

use App\Order;
use App\Release;
use App\Services\DeviceService;
use App\Services\ReaderService;
use App\Services\Toastr\Toastr;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReaderController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if (Auth::guest()) {

            (new Toastr('Необходимо авторизоваться'))->info(false);

            session()->flash('modal', 'login-modal');

            return view('reader.index', []);
        }

        $oUser = User::find(Auth::user()->id);

        $oDeviceService = new DeviceService($oUser);

        $device = $oDeviceService->getDevice();

        if (is_null($device)) {
            $device = $oDeviceService->saveDevice();
        } else {
            $oDeviceService->checkDevice($device);
        }

        if (is_null($device->code_at)) {

            $oDeviceService->sendEmail();

            (new Toastr('На email '.$oUser->email.' был отправлен код подтверждения устройства. '.$device->code))->info(false);

            session()->flash('modal', 'reader-code-modal');

            return view('reader.index', []);
        }

        if ($device->expires_at < now()) {

            $oDeviceService->sendEmail();

            (new Toastr('Срок действия устройства истек.'))->error(false);

            (new Toastr('На email '.$oUser->email.' был отправлен код подтверждения устройства. '.$device->code))->info(false);

            session()->flash('modal', 'reader-code-modal');

            return view('reader.index', []);
        }

        $oDeviceService->setOnline();

        $oRelease = !$request->exists('release_id') ? Release::first() : Release::where('id', $request->get('release_id'))->first();

        $oService = (new ReaderService())->byRelease($oRelease);

        $oJournal = $oService->getJournal();
        $oArticles = $oService->getArticles();
        $oReleases = $oService->getReleases();

        $oRelease->image = asset('img/covers/befc001381c5d89ccf4e3d3cd6c95cf0.png');

        return view('reader.index', [
            'oRelease' => $oRelease,
            'oReleases' => $oReleases,
            'oJournal' => $oJournal,
            'oArticles' => $oArticles,
        ]);
    }


    /**
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function code(Request $request)
    {
        $oUser = User::find(Auth::user()->id);

        $oDeviceService = new DeviceService($oUser);

        if (!$oDeviceService->checkCode((int)$request->get('code'))) {
            return responseCommon()->validationMessages(null, [
                'code' => 'Неверный код подтверждения',
            ]);
        }
        return responseCommon()->success([
            'result' => 3,
            'redirect' => url('/reader'),
        ], 'Код успешно подтвержден');
    }

}
