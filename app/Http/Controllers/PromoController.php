<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Models\PromoUser;
use App\Promocode;
use App\Services\PromoUserService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PromoController extends Controller
{
    public function index()
    {
        return view('promo');
    }

    public function access(Request $request)
    {
        $oPromocode = Promocode::where('promocode', $request->get('promocode'))->first();
        if (is_null($oPromocode)) {
            return responseCommon()->error([], 'Промокод не найден');
        }

        $oPromoUserService = new PromoUserService();

        // Проверка промокода
        if (!$oPromoUserService->checkPromocodeBeforeActivate($oPromocode)) {
            return responseCommon()->error([], $oPromoUserService->getMessage());
        }

        $oUser = User::where('email', $request->get('email'))->first();
        if (!is_null($oUser)) {
            return responseCommon()->error([
                'result' => 2,
            ], 'Найден пользователь с таким же email. Авторизуйтесь.');
        }
        $data['phone'] = preg_replace('/[^0-9]/','', $request->get('phone'));
        $validate = Validator::make($data, [
            'phone' => ['required', 'string', Rule::unique('users', 'phone')],
        ], [], [
            'phone' => 'Моб. телефон',
        ]);
        if ($validate->fails()) {
            return responseCommon()->jsonError([
                'errors' => $validate->getMessageBag()->toArray()
            ]);
        }

        return response()->json([
            'success' => true,
            'result' => 1,
            'data' => $request->all()
        ]);
    }

    public function code(Request $request)
    {
        $oPromocode = Promocode::where('promocode', $request->get('promocode'))->first();
        if (is_null($oPromocode)) {
            return responseCommon()->error([], 'Промокод не найден');
        }

        $oPromoUserService = new PromoUserService();

        // Если пользователь уже авторизован, то данные из формы записываются в его профиль.
        if (!Auth::guest()) {
            $oUser = Auth::user();
        } else {
            // ищется пользователь с таким же email для авторизации
            $oUser = User::where('email', $request->get('email'))->first();
            if (is_null($oUser)) {
                $data = $request->all();
                $request->merge([
                    'name' => $data['name'],
                    'last_name' => $data['surname'],
                    'email' => $data['email'],
                    'phone' => preg_replace('/[^0-9]/','', $data['phone']),
                    'password' => '1234567890',
                    'password_confirmation' => '1234567890',
                    'g-recaptcha-response' => config('googlerecaptchav3.except_value')
                ]);
                (new RegisterController())->register($request);
            } else {
                // Если найден, то открывается окно для ввода пароля.
                Auth::login($oUser);
            }
            $oUser = Auth::user();
        }

        $oPromoUser = $oUser->promo;
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
            return responseCommon()->error([], $oPromoUserService->getMessage());
        }

        // У промокода увеличивается на 1 свойство "использован", промо-участнику в "активированные промокоды" добавляется введенный промокод и при необходимости добавляется выбранное издательство.
        // После активации происходит переход на страницу "Мои журналы", а для промокода вида "Выборочный" переход на страницу выбора журналов.
        return responseCommon()->success([
            'redirect' => '/promo'
        ], 'Промокод успешно активирован');
    }


    public function password(Request $request)
    {
        $oPromocode = Promocode::where('promocode', $request->get('promocode'))->first();
        if (is_null($oPromocode)) {
            return responseCommon()->error([], 'Промокод не найден');
        }

        try {
            $login = (new LoginController())->login($request);

            $oUser = Auth::user();

            $oPromoUserService = new PromoUserService();

            $oPromoUser = $oUser->promo;
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
                return responseCommon()->error([], $oPromoUserService->getMessage());
            }

            // У промокода увеличивается на 1 свойство "использован", промо-участнику в "активированные промокоды" добавляется введенный промокод и при необходимости добавляется выбранное издательство.
            // После активации происходит переход на страницу "Мои журналы", а для промокода вида "Выборочный" переход на страницу выбора журналов.
            return responseCommon()->success([
                'redirect' => '/promo'
            ], 'Промокод успешно активирован');
        } catch (\Exception $e) {
            return responseCommon()->error([], 'Неверный пароль');
        }
    }

}
