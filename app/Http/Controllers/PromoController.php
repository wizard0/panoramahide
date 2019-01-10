<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PromoController extends Controller
{
    public function index()
    {
        return view('promo');
    }

    public function access(Request $request)
    {
        return response()->json([
            'success' => true,
            'result' => 1,
            'data' => $request->all()
        ]);
    }

    public function code(Request $request)
    {

        // Если пользователь уже авторизован, то данные из формы записываются в его профиль.
        if (!Auth::guest()) {
            $oUser = Auth::user();
            // Если найден, то активация промокода
            if (true) {
                // создание промо-участника и использования кода
                if ($request->get('code')) {

                }
                // У промокода увеличивается на 1 свойство "использован", промо-участнику в "активированные промокоды" добавляется введенный промокод и при необходимости добавляется выбранное издательство.
                // После активации происходит переход на страницу "Мои журналы", а для промокода вида "Выборочный" переход на страницу выбора журналов.
            } else {
                // Создается, используются данные из формы
            }
        } else {
            // ищется пользователь с таким же email для авторизации
            if ($request->get('email')) {

                // Если найден, то открывается окно для ввода пароля.
                if (true) {
                    return response()->json([
                        'success' => true,
                        'result' => 1,
                    ]);
                } else {
                    // Создается, используются данные из формы

                    // создание промо-участника и использования кода
                    if ($request->get('code')) {

                    }
                }
            }
        }

        return response()->json([
            'success' => true,
            'data' => $request->all()
        ]);
    }

}
