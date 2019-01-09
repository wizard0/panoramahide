<?php

namespace Tests\Unit\Services;


use App\Models\PromoUser;
use App\Promocode;
use App\Services\PromoUserService;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PromoUserServiceTest extends TestCase
{
    /**
     * Пример использования
     */
    public function example()
    {
        $oPromoUser = PromoUser::first();
        $oPromoCode = Promocode::first();
        $service = (new PromoUserService($oPromoUser));
        if (!$service->activatePromocode($oPromoCode)) {
            // не удалось активировать, вызвать сообщение $service->getMessage()
        }

        if (!$service->deactivatePromocode($oPromoCode)) {
            // не удалось деактивировать, вызвать сообщение $service->getMessage()
        }
    }

    /**
     * Проверка сценариев вызовов ошибок
     * - Проверка на просроченность промокода
     * - Проверка на существование
     * - Деактивация не существовующего промокода
     */
    public function testCheckExceptions()
    {
        $oPromoUser = PromoUser::first();
        if (is_null($oPromoUser)) {
            $this->assertTrue(true);
            return;
        }

        // Проверка на просроченность промокода
        $now = now();
        $oPromoCode = Promocode::where('release_end', '<', $now)->first();
        if (!is_null($oPromoCode)) {
            DB::transaction(function () use ($oPromoUser, $oPromoCode) {
                $service = (new PromoUserService($oPromoUser));
                $result = $service->activatePromocode($oPromoCode);
                $this->assertFalse($result, 'PromoUserServiceTest: activate by release_end, must be false');
                DB::rollBack();
            });
        }

        // Проверка на существование
        $oPromocodes = $oPromoUser->promocodes;
        if (!empty($oPromocodes)) {
            $oPromoCode = Promocode::whereIn('id', $oPromocodes->pluck('id'))->first();
            if (!is_null($oPromoCode)) {
                DB::transaction(function () use ($oPromoUser, $oPromoCode) {
                    $service = (new PromoUserService($oPromoUser));
                    $result = $service->activatePromocode($oPromoCode);
                    $this->assertFalse($result, 'PromoUserServiceTest: activate by isset promocode, must be false');
                    DB::rollBack();
                });
            }
        }

        // Деактивация не существовующего промокода
        if (!empty($oPromocodes)) {
            $oPromoCode = Promocode::whereNotIn('id', $oPromocodes->pluck('id'))->first();
            if (!is_null($oPromoCode)) {
                DB::transaction(function () use ($oPromoUser, $oPromoCode) {
                    $service = (new PromoUserService($oPromoUser));
                    $result = $service->deactivatePromocode($oPromoCode);
                    $this->assertFalse($result, 'PromoUserServiceTest: deactivate by isset promocode, must be false');
                    DB::rollBack();
                });
            }
        }

        $this->assertTrue(true);
    }
}
