<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Route;
use View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // Если переданное условие не истина, отправляем на страницу ошибки с текстом $message
    public static function errorMessage($condition, $message)
    {
        if (!$condition) {
            exit(view('error', compact('message'))->render());
        } else {
            // При получении экземпляра удобно его сразу вернуть
            return $condition;
        }
    }
    // Добавление в представление переменной с именем маршрута
    public static function getRouteNameToView($default = null)
    {
        View::share('route_name', $default ?? Route::currentRouteName());
    }
}
