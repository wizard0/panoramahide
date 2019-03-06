<?php

namespace App\Http\Controllers;

use App\Release;
use App\Models\Partner;
use App\Models\PartnerUser;
use App\Models\Quota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ReaderApiController extends Controller
{
    private static function checkPermission($partner, $user, &$quota)
    {
        // Проверяем что есть такая квота
        $quota = self::errorMessage(Quota::find($quota), 'Квота не найдена');
        // Проверяем что ключ партнёра указан верно
        self::errorMessage($quota->partner->secret_key === $partner, 'Неверный secret_key пртнёра');
        // Проверяем что такой пользователь есть у партнёра
        $pUser = $quota->partner->users()->whereUserId($user)->first();
        if (!$pUser) {
            $quota->partner->users()->save(PartnerUser::create(['user_id' => $user, 'partner_id' => $quota->partner->id]));
        }
    }
    public function list($partner, $user, $quota)
    {
        // Проверяем ключ партнёра, пользователя и ID квоты
        self::checkPermission($partner, $user, $quota);
        // Получаем список доступных выпусков по квоте
        $releases = $quota->getReleases();
        // Выводим представление со списком выпусков
        return view('release.list.index', compact('partner', 'user', 'quota', 'releases'));
    }
    public function release($partner, $user, $quota, $relese)
    {
        // Проверяем ключ партнёра, пользователя и ID квоты
        self::checkPermission($partner, $user, $quota);
        // Проверяем, что выпуск доступен по квоте
        $release = self::errorMessage($quota->getReleases()->find($relese), 'Нет доступа к этому выпуску');
        $user = PartnerUser::whereUserId($user)->first();
        // Проверяем, получал ли пользователь доступ к этому выпуску раньше
        if (!$user->releases()->find($release->id)) {
            // Если не получал, то используем квоту
            self::errorMessage($user->useQuota($quota->id), 'Невозможно использовать квоту');
            // Устанавливаем отношение пользователь->выпуск
            $user->releases()->save($release);
        }
        Cookie::queue(PartnerUser::COOKIE_NAME, $user->partner->id . PartnerUser::COOKIE_NAME_SEPORATOR . $user->user_id);

        // Отправляем пользователя на читалку
        return redirect(route('reader.index', ['release_id' => $release->id]));
    }
}
