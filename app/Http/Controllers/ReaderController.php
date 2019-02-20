<?php

namespace App\Http\Controllers;

use App\Models\PartnerUser;
use App\Models\Device;
use App\Release;
use App\Services\DeviceService;
use App\Services\ReaderService;
use App\Services\Toastr\Toastr;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use View;

class ReaderController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public static function getUser(Request $request)
    {
        $isAjax = $request->ajax();

        if (!$isAjax) {
            // Для представления задаём значения: не партнёр, простой вид читалки
            View::share('isPartnerUser', false);
            View::share('simpleReader', true);
        }

        // Если пользователь авторизован, получаем его
        $User = Auth::guest() ? null : Auth::user();

        // Если юзер портала, то вид читалки - расширенный
        if ($User && !$isAjax)
            View::share('simpleReader', false);

        // Получаем пользователя партнёра по куке
        if (PartnerUser::getUserByCookie($User)) {
            // Если юзер партнёра, то вид читалки - простой
            if (!$isAjax)
                View::share('isPartnerUser', true);
        }
        return $User;
    }
    public function index(Request $request)
    {
        $oUser = self::getUser($request);

        if (!$oUser) {
            (new Toastr('Необходимо авторизоваться'))->info(false);
            session()->flash('modal', 'login-modal');
            return view('reader.index', []);
        }

        if (session()->exists('reset-wrong')) {

            $this->sessionModalError('reset-wrong-modal', null, null);

            return view('reader.index', []);
        }

        if (session()->exists('reset-success')) {

            session()->forget('reset-success');

            (new Toastr('Устройства успешно сброшены'))->success(false);
        }

        $oDevice = $this->getCookieDeviceId($request);

        if (is_null($oDevice)) {
            // Если устройство новое
            $oDevice = $oUser->createDevice();
        } else {
            $oDevice = $oUser->devices()->find($oDevice);
            // В жизни врятли повторится, но при тестировании возникло. Если с одного устройства заходят разные пользователи
            if (!$oDevice)
                $oDevice = $oUser->createDevice();
        }

        $oActivationDevices = $oUser->getActivationDevices($oDevice);
        if (count($oActivationDevices) >= 2) {
            $this->sessionModalError('max', $oDevice, $oUser);
            return view('reader.index', []);
        }

        if (!$oDevice->checkActivation()) {
            $this->sessionModalError('activation', $oDevice, $oUser);
            return view('reader.index', []);
        }

        if ($oUser->hasOnlineDevices($oDevice)) {
            $this->sessionModalError('online', $oDevice, $oUser);
            return view('reader.index', []);
        }

        $oDevice->setOnline();

        if ($request->has('release_id'))
            View::share('release_id', $request->get('release_id'));

        return view('reader.index', []);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function release(Request $request)
    {
        $User = self::getUser($request);
        $oRelease = !$request->exists('id') ? Release::first() : Release::where('id', $request->get('id'))->first();
        if (!$oRelease->userHasPermission($User)) {
            return responseCommon()->error([], 'У вас нет доступа к данному выпуску');
        }

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
     * @param $oDevice
     * @param $oUser
     */
    private function sessionModalError($type, $oDevice = null, $oUser = null)
    {
        switch ($type) {
            case 'login':

                (new Toastr('Необходимо авторизоваться'))->info(false);

                session()->flash('modal', 'login-modal');

                break;
            case 'max':

                session()->flash('modal', 'reader-max-devices-modal');

                break;
            case 'reset-wrong-modal':

                if (session()->has('wrong-reset')) {
                    session()->forget('wrong-reset');
                }

                (new Toastr('Неверный код сброса устройств'))->error(false);

                session()->flash('modal', 'reader-max-devices-modal');

                break;
            case 'reset-wrong':

                session()->put('reset-wrong', 'reader-max-devices-modal');

                break;
            case 'reset-success':

                session()->put('reset-success', 'reader-max-devices-modal');

                break;
            case 'activation':

                $oDevice->sendCodeToUser();

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
        //$oUser = User::find(Auth::user()->id);

        $deviceID = $this->getCookieDeviceId($request);

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
            'redirect' => redirect()->back()->getTargetUrl(),
        ], 'Код успешно подтвержден');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function online(Request $request)
    {
        $deviceID = $this->getCookieDeviceId($request);

        if (is_null($deviceID)) {
            return responseCommon()->error([

            ], 'Устройство не найдено');
        } else {
            $oDevice = Device::find($deviceID);
        }

        $oUser = $oDevice->user;

        if ($request->exists('online') && (int)$request->get('online') === 1) {

            $oDevices = $oUser->devices;

            foreach ($oDevices as $device) {
                $device->online_datetime = null;
                $device->save();
            }
            $oDevice->setOnline();

            return responseCommon()->success([
                'result' => 4,
                'redirect' => redirect()->back()->getTargetUrl(),
            ], 'Устройство успешно подтверждено');
        }

        if ($request->exists('reset') && (int)$request->get('reset') === 1) {

            $oUser->sendResetCodeToUser();

            return responseCommon()->success([
                'result' => 5,
            ], 'Ссылка успешно отправлена.');
        }

        if (!$oDevice->isOnline()) {

            return responseCommon()->error([

            ], 'Читалка уже открыта на другом устройстве');
        }

        $oDevice->setOnline();

        return responseCommon()->success([]);
    }

    /**
     * @param Request $request
     * @return array|null|string
     */
    private function getCookieDeviceId(Request $request)
    {
        return !is_null($request->cookie('device_id')) ?
            $request->cookie('device_id') : $_COOKIE['device_id'] ?? null;
    }

    /**
     * @param Request $request
     * @param $code
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function reset(Request $request, $code)
    {
        if (Auth::guest()) {

            $this->sessionModalError('login', null, null);

            return view('reader.index', []);
        }

        $oUser = Auth::user();

        if (!$oUser->checkResetCode($code)) {

            $this->sessionModalError('reset-wrong', null, null);

            return redirect()->to('/reader');
        }

        $oUser->resetAllDevices();

        $this->sessionModalError('reset-success', null, null);

        return redirect()->to('/reader');
    }


}
