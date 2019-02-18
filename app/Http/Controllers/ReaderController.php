<?php

namespace App\Http\Controllers;

use App\Release;
use App\Services\DeviceService;
use App\Services\ReaderService;
use App\Services\Toastr\Toastr;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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

        $device = $oDeviceService->getCurrentDevice();

        if (is_null($device)) {

            if ($oDeviceService->canCreate()) {
                $device = $oDeviceService->createDevice();
            } else {
                $this->sessionModalError('exists', $oDeviceService, $oUser, $device);

                (new Toastr($oDeviceService->getMessage()))->error(false);

                return view('reader.index', []);
            }
        }

        $oDeviceService->checkDevice($device);

        if (is_null($device->code_at)) {

            $this->sessionModalError('code_at', $oDeviceService, $oUser, $device);

            return view('reader.index', []);
        }

        if ($device->expires_at < now()) {

            $this->sessionModalError('expires_at', $oDeviceService, $oUser, $device);

            return view('reader.index', []);
        }

        if ($oDeviceService->hasOnline() && !$oDeviceService->checkOnline()) {

            $this->sessionModalError('online', $oDeviceService, $oUser, $device);

            return view('reader.index', []);
        }

        $oDeviceService->setOnline();

        return view('reader.index', []);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function release(Request $request)
    {
        $oRelease = !$request->exists('id') ? Release::first() : Release::where('id', $request->get('id'))->first();

        $oRelease->image = asset('img/covers/befc001381c5d89ccf4e3d3cd6c95cf0.png');

        return responseCommon()->success([
            'data' => $oRelease->toArray(),
        ]);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function releases(Request $request)
    {
        $oRelease = !$request->exists('id') ? Release::first() : Release::where('id', $request->get('id'))->first();

        $oService = (new ReaderService())->byRelease($oRelease);

        $oReleases = $oService->getReleases();

        return responseCommon()->success([
            'data' => $oReleases->toArray(),
        ]);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function articles(Request $request)
    {
        $oRelease = !$request->exists('release_id') ? Release::first() : Release::where('id', $request->get('release_id'))->first();

        $oService = (new ReaderService())->byRelease($oRelease);

        $oArticles = $oService->getArticles();

        return responseCommon()->success([
            'data' => $oArticles->toArray(),
        ]);
    }

    /**
     * @param $type
     * @param DeviceService $oDeviceService
     * @param $oUser
     * @param $device
     */
    private function sessionModalError($type, DeviceService $oDeviceService, $oUser, $device)
    {
        switch ($type) {
            case 'exists':

                session()->flash('modal', 'reader-max-devices-modal');

                break;
            case 'code_at':
                $oDeviceService->sendEmailConfirmDevice();

                (new Toastr('На email ' . $oUser->email . ' был отправлен код подтверждения устройства.'))->info(false);

                session()->flash('modal', 'reader-code-modal');

                break;
            case 'expires_at':
                $oDeviceService->sendEmailConfirmDevice();

                (new Toastr('Срок действия устройства истек.'))->error(false);

                (new Toastr('На email ' . $oUser->email . ' был отправлен код подтверждения устройства.'))->info(false);

                session()->flash('modal', 'reader-code-modal');

                break;
            case 'online':

                (new Toastr('Читалка уже открыта на другом устройстве'))->info(false);

                session()->flash('modal', 'reader-confirm-online-modal');

                break;
            default:
                break;
        }
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

    /**
     * @param Request $request
     * @return array
     */
    public function online(Request $request)
    {
        $oUser = User::find(Auth::user()->id);

        $oDeviceService = new DeviceService($oUser);

        if ($request->exists('reset') && (int)$request->get('reset') === 1) {

            $oDeviceService->sendEmailResetDevice();

            return responseCommon()->success([
                'result' => 5,
            ], 'Ссылка успешно отправлена.');
        }

        if (!$request->exists('online') && !$oDeviceService->checkOnline()) {

            return responseCommon()->error([

            ], 'Читалка уже открыта на другом устройстве');
        }

        if ($request->exists('online') && (int)$request->get('online') === 1) {

            $oDeviceService->setOnline();

            return responseCommon()->success([
                'result' => 4,
                'redirect' => url('/reader'),
            ], 'Устройство успешно подтверждено');
        }

        return responseCommon()->success([

        ]);
    }


}
