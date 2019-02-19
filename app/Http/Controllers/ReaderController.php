<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Release;
use App\Services\DeviceService;
use App\Services\ReaderService;
use App\Services\Toastr\Toastr;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
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

        $deviceID = $request->cookie('device_id');

        if (is_null($deviceID)) {
            $oDevice = null;
        } else {
            $oDevice = Device::find($deviceID);
        }
        if (is_null($oDevice)) {
            $oDevice = $oUser->createDevice();
            Cookie::queue('device_id', $oDevice->id, Device::ACTIVE_DAYS * 1440);
        }
        if (!$oDevice->checkActivation()) {

            $oDevice->sendCodeToUser();

            (new Toastr('На email ' . $oUser->email . ' был отправлен код подтверждения устройства.'))->info(false);

            session()->flash('modal', 'reader-code-modal');

            return view('reader.index', []);
        }

        if ($oUser->hasOnlineDevices($oDevice)) {

            (new Toastr('Читалка уже открыта на другом устройстве'))->info(false);

            session()->flash('modal', 'reader-confirm-online-modal');

            return view('reader.index', []);
        }
        $oDevice->setOnline();

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

        $deviceID = $request->cookie('device_id');

        if (is_null($deviceID)) {
            return responseCommon()->validationMessages(null, [
                'code' => 'Устройство не найдено',
            ]);
        } else {
            $oDevice = Device::find($deviceID);
        }
        $oDevice = $oDevice->activateByCode($request->get('code'));

        if (is_null($oDevice)) {
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

        $deviceID = $request->cookie('device_id');

        if (is_null($deviceID)) {
            return responseCommon()->error([

            ], 'Устройство не найдено');
        } else {
            $oDevice = Device::find($deviceID);
        }

        if ($request->exists('online') && (int)$request->get('online') === 1) {

            $oDevices = $oUser->devices;

            foreach ($oDevices as $device) {
                $device->online_datetime = null;
                $device->save();
            }
            $oDevice->setOnline();

            return responseCommon()->success([
                'result' => 4,
                'redirect' => url('/reader'),
            ], 'Устройство успешно подтверждено');
        }

        if ($request->exists('reset') && (int)$request->get('reset') === 1) {

            // Отправить ссылку на почту, ссылка уже вызывает этот метод
            $oDevice->resetAllDevices();

            return responseCommon()->success([
                'result' => 5,
            ], 'Ссылка успешно отправлена.');
        }

        if (!$oDevice->isOnline()) {

            return responseCommon()->error([

            ], 'Читалка уже открыта на другом устройстве');
        }

        //$oDevice->setOnline();

        return responseCommon()->success([]);
    }


}
