<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Models\Journal;
use App\Models\Activations;
use App\Models\Group;
use App\Models\PromoUser;
use App\Models\Promocode;
use App\Services\Code;
use App\Services\PromocodeCustomService;
use App\Services\PromocodeService;
use App\Services\PromoUserService;
use App\Services\Toastr\Toastr;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PromoController extends Controller
{
    /**
     * Страница /promo
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('promo');
    }

    /**
     *  Страница /deskbooks
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function deskbooks(Request $request)
    {
        if (Auth::guest()) {
            return view('deskbooks', [
                'oGroups' => collect([]),
            ]);
        }

        $oGroups = Group::with('journals', 'promocode')
            ->where('active', true);

        if ($request->exists('promocode')) {
            $oGroups = $oGroups->where('promocode_id', $request->get('promocode'));
        }
        $oGroups = $oGroups->whereHas('promocode', function ($query) {
            $query->where('type', 'custom');
        });

        $oGroups = $oGroups->get();

        $oPromoUser = Auth::user()->promoUser;

        $oJournals = (new PromocodeCustomService())->setPromoUser($oPromoUser)->getPromoUserJournals();

        if (count($oGroups) !== 0) {
            $oGroups = $oGroups->transform(function ($item) use ($oJournals) {
                $count = 0;
                foreach ($item->journals as $key => $oJournal) {
                    $checked = !is_null($oJournals->where('id', $oJournal->id)->first());
                    $item->journals[$key]->checked = $checked;
                    if ($checked) {
                        $count++;
                    }
                }
                $item->selected = $count;
                $item->max = $item->promocode->release_limit;
                return $item;
            });
        }

        return view('deskbooks', [
            'oGroups' => $oGroups,
        ]);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function save(Request $request)
    {
        $aJournals = $request->get('journal::promocode');

        $oPromoUser = Auth::user()->promoUser;
        $oService = new PromocodeCustomService(null, $oPromoUser);

        $a = [];
        foreach ($aJournals as $id) {
            $array = explode('::', $id);
            $a[$array[1]][] = $array[0];
        }
        foreach ($a as $promocode_id => $journals) {
            $oPromocode = Promocode::find($promocode_id);
            $oJournals = Journal::find($journals);
            $result = $oService->setPromocode($oPromocode)->syncJournal($oJournals);
            if (!$result) {
                return responseCommon()->error([], $oService->getMessage());
            }
        }
        return responseCommon()->success([], 'Журналы успешно сохранены');
    }

    /**
     * Основная форма
     * - проверка промокода
     * - проверка промокода на активацию
     * - поиск пользователя по email, если сущетсвует, то окно с Авторизацией
     * - проверка телефона на существование
     * - генерация кода подтверждения для новых пользователей
     *
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function access(Request $request)
    {
        $oPromocodeService = new PromocodeService();
        $oPromocode = $oPromocodeService->findByCode($request->get('promocode'));

        if (is_null($oPromocode)) {
            return responseCommon()->error([], 'Промокод не найден');
        }

        $oPromoUserService = new PromoUserService();


        // Проверка промокода
        if (!$oPromocodeService->checkPromocodeBeforeActivate($oPromocode)) {
            return responseCommon()->error([], $oPromocodeService->getMessage());
        }

        $phone = preg_replace('/[^0-9]/', '', $request->get('phone'));

        if (Auth::guest()) {
            $oUser = User::where('email', $request->get('email'))->first();
            if (!is_null($oUser)) {
                return responseCommon()->error([
                    'result' => 2,
                    'type' => 'info',
                ], 'Найден пользователь с таким же email. Авторизуйтесь.');
            }
            $data['phone'] = $phone;
            $validate = Validator::make($data, [
                'phone' => ['required', 'string', Rule::unique('users', 'phone')],
            ], [], [
                'phone' => 'Моб. телефон',
            ]);
            if ($validate->fails()) {
                return responseCommon()->jsonError([
                    'errors' => $validate->getMessageBag()->toArray(),
                ]);
            }
        }
        $code = $oPromoUserService->codeGenerateByPhone(intval($phone));

        return responseCommon()->success([
            'result' => 1,
            'code' => $code,
        ], 'На указанный номер телефона был отправлен код подтверждения ' . $code);
    }

    /**
     * Модальное окно с кодом подтверждения
     * - проверка промокода
     * - проверка кода подтверждения, закрытие его
     * - регистрация пользователя
     * - авторизация пользователя
     *
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function code(Request $request)
    {
        $oPromocodeService = new PromocodeService();
        $oPromocode = $oPromocodeService->findByCode($request->get('promocode'));

        if (is_null($oPromocode)) {
            return responseCommon()->error([], 'Промокод не найден');
        }
        $oPromoUserService = new PromoUserService();

        $phone = preg_replace('/[^0-9]/', '', $request->get('phone'));

        $checkCode = $oPromoUserService->codeCheckByPhone((int) $phone, (int) $request->get('code'));
        if (!$checkCode) {
            return responseCommon()->validationMessages(null, [
                'code' => 'Неверный код подтверждения',
            ]);
        }

        // Если пользователь уже авторизован, то данные из формы записываются в его профиль.
        if (!Auth::guest()) {
            $oUser = Auth::user();
        } else {
            // ищется пользователь с таким же email для авторизации
            $oUser = User::where('email', $request->get('email'))->first();
            if (is_null($oUser)) {
                $data = $request->all();

                /**
                 * @todo Сделать отправку email со сгенерованным паролем
                 */
                $request->merge([
                    'name' => $data['name'] ?? 'Имя',
                    'last_name' => $data['surname'] ?? 'Фамилия',
                    'email' => $data['email'],
                    'phone' => $phone,
                    'password' => '1234567890',
                    'password_confirmation' => '1234567890',
                    'g-recaptcha-response' => config('googlerecaptchav3.except_value'),
                ]);
                (new RegisterController())->register($request);
            } else {
                // Если найден, то открывается окно для ввода пароля.
                Auth::login($oUser);
            }
            $oUser = Auth::user();
        }

        // У промокода увеличивается на 1 свойство "использован", промо-участнику в "активированные промокоды" добавляется введенный промокод и при необходимости добавляется выбранное издательство.
        // После активации происходит переход на страницу "Мои журналы", а для промокода вида "Выборочный" переход на страницу выбора журналов.
        return responseCommon()->success([
            'result' => 3,
        ], 'Код успешно подтвержден');
    }


    /**
     * Модальное окно с паролем
     * - проверка промокода
     * - проверка логин|пароль
     * - авторизация
     *
     * @param Request $request
     * @return array
     */
    public function password(Request $request)
    {
        $oPromocodeService = new PromocodeService();
        $oPromocode = $oPromocodeService->findByCode($request->get('promocode'));

        if (is_null($oPromocode)) {
            return responseCommon()->error([], 'Промокод не найден');
        }

        try {
            $login = (new LoginController())->login($request);

            $oUser = Auth::user();

            return responseCommon()->success([
                'result' => 3,
            ], 'Вход успешно выполнен');
        } catch (\Exception $e) {
            return responseCommon()->error([], 'Неверный пароль');
        }
    }

    /**
     * Модальное окно с активацией промокода
     * - проверка промокода
     * - поиск промо-участника/создание промо-участника
     * - активация промокода
     * - редирект на нужную страницу
     *
     * @param Request $request
     * @return array
     */
    public function activation(Request $request)
    {
        $oPromocodeService = new PromocodeService();
        $oPromocode = $oPromocodeService->findByCode($request->get('promocode'));

        if (is_null($oPromocode)) {
            return responseCommon()->error([], 'Промокод не найден');
        }

        $oUser = Auth::user();

        $oPromoUserService = new PromoUserService();

        $oPromoUser = $oUser->promoUser;
        if (is_null($oPromoUser)) {
            // создание промо-участника и использования кода
            $oPromoUser = $oPromoUserService->create([
                'name' => $request->get('name'),
                'user_id' => $oUser->id,
                'phone' => $request->get('phone'),
            ]);
        }

        $oPromoUserService->setPromoUser($oPromoUser);

        if (!$oPromoUserService->activatePromocode($oPromocode)) {
            return responseCommon()->error([
                'message' => 'Ошибка активации промокода. ' . $oPromoUserService->getMessage(),
            ], $oPromoUserService->getMessage());
        }

        // У промокода увеличивается на 1 свойство "использован", промо-участнику в "активированные промокоды" добавляется введенный промокод и при необходимости добавляется выбранное издательство.
        // После активации происходит переход на страницу "Мои журналы", а для промокода вида "Выборочный" переход на страницу выбора журналов.

        (new Toastr('Промокод успешно активирован'))->success(false);

        $redirect = $oPromocodeService->redirectsByType();

        return responseCommon()->success([
            'redirect' => $redirect,
        ], 'Промокод успешно активирован');
    }
}
