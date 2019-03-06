<?php
/**
 * ReadController
 * PHP version 7.x
 *
 * @category App\Http\Cpontrollers\
 * @package  App\Http\Cpontrollers\ReaderController
 * @author   Илья Картунин (ikartunin@gmail.com)
 * @license  Proprietary http://gl.panor.ru/LICENSE
 */

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\PartnerUser;
use App\Release;
use App\Services\ReaderService;
use App\Services\Toastr\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

/**
 * Controls the data flow into a reader object and updates the view
 * whenever data changes. *
 */
class ReaderController extends Controller
{
    /**
     * Gets the user.
     *
     * @param \Illuminate\Http\Request $request The request
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null|false The user.
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
        if ($User && !$isAjax) {
            View::share('simpleReader', false);
        }

        // Получаем пользователя партнёра по куке
        if (PartnerUser::getUserByCookie($User)) {
            // Если юзер партнёра, то вид читалки - простой
            if (!$isAjax) {
                View::share('isPartnerUser', true);
            }
        }
        return $User;
    }

    /**
     * Index function
     *
     * @param \Illuminate\Http\Request $request The request
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        $oUser = self::getUser($request);

        if (!$oUser) {
            (new Toastr('Необходимо авторизоваться'))->info(false);
            session()->flash('modal', 'login-modal');
            return view('reader.index', []);
        }

        if (empty($oUser->email)) {
            $this->sessionModalError('show-email-modal', null, null);
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

        $oDevice = Device::getCookieDeviceId($request);

        if (is_null($oDevice)) {
            // Если устройство новое
            $oDevice = $oUser->createDevice();
        } else {
            $oDevice = $oUser->devices()->find($oDevice);
            // В жизни врятли повторится, но при тестировании возникло.
            // Если с одного устройства заходят разные пользователи
            if (!$oDevice) {
                $oDevice = $oUser->createDevice();
            }
        }

        if (!$oDevice->checkActivation()) {
            if ($oUser->getActivationDevices()->count() >= 2) {
                switch ($oDevice->owner_type) {
                    case 'partner_user':
                        $this->sessionModalError('max-for-partner-user', $oDevice, $oUser);
                        break;
                    default:
                        $this->sessionModalError('max', $oDevice, $oUser);
                }
                return view('reader.index', []);
            } else {
                $this->sessionModalError('activation', $oDevice, $oUser);
                return view('reader.index', []);
            }
        }

        if ($oUser->hasOnlineDevices($oDevice)) {
            $this->sessionModalError('online', $oDevice, $oUser);
            return view('reader.index', []);
        }

        $oDevice->setOnline();

        if ($request->has('release_id')) {
            View::share('release_id', $request->get('release_id'));
        }

        return view('reader.index', []);
    }

    /**
     * Release method
     *
     * @param \Illuminate\Http\Request $request The request
     *
     * @return array
     */
    public function release(Request $request)
    {
        $User = self::getUser($request);
        $oRelease = !$request->exists('id') ? Release::first() : Release::where('id', $request->get('id'))->first();
        if (!$User || !$oRelease->userHasPermission($User)) {
            return responseCommon()->error([], 'У вас нет доступа к данному выпуску');
        }

        $oRelease->image = asset('img/covers/befc001381c5d89ccf4e3d3cd6c95cf0.png');

        return responseCommon()->success([
            'data' => $oRelease->toArray(),
        ]);
    }

    /**
     * Releases method
     *
     * @param \Illuminate\Http\Request $request The request
     *
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
        $oRelease = !$request->exists('release_id')
            ? Release::first()
            : Release::where('id', $request->get('release_id'))->first();

        $oService = (new ReaderService())->byRelease($oRelease);

        $oArticles = $oService->getArticles();

        return responseCommon()->success([
            'data' => $oArticles->toArray(),
        ]);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function bookmarks(Request $request)
    {
        $oRelease = !$request->exists('release_id') ? Release::first() : Release::where('id', $request->get('release_id'))->first();

        $oService = (new ReaderService())->byRelease($oRelease);

        $oBookmarks = $oService->getBookmarks();

        return responseCommon()->success([
            'data' => $oBookmarks->toArray(),
        ]);
    }

    /**
     * @param Request $request
     * @param integer $id
     * @return array
     */
    public function bookmarksDestroy(Request $request, $id)
    {
        $oService = (new ReaderService())->bookmarkDestroy($id);

        return responseCommon()->success([]);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function bookmarksCreate(Request $request)
    {
        $oService = (new ReaderService())->bookmarkCreate($request->all());

        return responseCommon()->success([]);
    }

    /**
     * @param string $type
     * @param \App\Models\Device|null $oDevice
     * @param \Illuminate\Contracts\Auth\Authenticatable|null $oUser
     */
    private function sessionModalError(string $type, $oDevice = null, $oUser = null)
    {
        switch ($type) {
            case 'login':
                (new Toastr('Необходимо авторизоваться'))->info(false);
                session()->flash('modal', 'login-modal');
                break;
            case 'max':
                session()->flash('modal', 'reader-max-devices-modal');
                break;
            case 'max-for-partner-user':
                session()->flash('modal', 'reader-max-pu-devices-modal');
                break;
            case 'reset-wrong-modal':
                if (session()->has('reset-wrong')) {
                    session()->forget('reset-wrong');
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
            case 'show-email-modal':
                session()->flash('modal', 'reader-email-modal');
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
        }
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function code(Request $request)
    {
        //$oUser = User::find(Auth::user()->id);

        $deviceID = Device::getCookieDeviceId($request);

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

    public function email(Request $request)
    {
        $validator = responseCommon()->validation($request->all(), ['email' => 'required|email']);
        if ($validator->fails()) {
            return responseCommon()->validationMessages(null, ['email' => 'Неверный формат email']);
        }

        $oUser = self::getUser($request);
        $oUser->email = $request->get('email');
        $oUser->save();

        return responseCommon()->success([
            'result' => 3,
            'redirect' => redirect()->back()->getTargetUrl(),
        ], 'Email сохранён');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function online(Request $request)
    {
        $deviceID = Device::getCookieDeviceId($request);

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
            return responseCommon()->error([], 'Читалка уже открыта на другом устройстве');
        }

        $oDevice->setOnline();

        return responseCommon()->success([]);
    }

    /**
     * Reset function
     *
     * @param Request $request
     * @param string $code
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
