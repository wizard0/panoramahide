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
     * Проверка на просроченность промокода
     */
    public function testCheckExceptionsReleaseEnd()
    {
        $oPromoUser = PromoUser::first();
        $this->assertNotNull($oPromoUser, 'Table promo_users is empty');

        $oPromoCode = Promocode::where('release_end', '<', now())->first();
        $this->assertNotNull($oPromoCode);

        DB::transaction(function () use ($oPromoUser, $oPromoCode) {
            $service = (new PromoUserService($oPromoUser));
            $result = $service->activatePromocode($oPromoCode);
            $this->assertFalse($result, 'Activate by release_end, must be false');
            DB::rollBack();
        });
    }

    /**
     * Активация существующего промокода
     */
    public function testCheckExceptionsActivateExists()
    {
        $oPromoUser = PromoUser::first();
        $this->assertNotNull($oPromoUser, 'Table promo_users is empty');

        $oPromocodes = $oPromoUser->promocodes;
        $this->assertNotEmpty($oPromocodes);

        $oPromoCode = Promocode::whereIn('id', $oPromocodes->pluck('id'))->first();
        $this->assertNotNull($oPromoCode);

        DB::transaction(function () use ($oPromoUser, $oPromoCode) {
            $service = (new PromoUserService($oPromoUser));
            $result = $service->activatePromocode($oPromoCode);
            $this->assertFalse($result, 'Activate by isset promocode, must be false');
            DB::rollBack();
        });
    }

    /**
     * Деактивация не существовующего промокода
     */
    public function testCheckExceptionsDeactivateNotExists()
    {
        $oPromoUser = PromoUser::first();
        $this->assertNotNull($oPromoUser, 'Table promo_users is empty');

        $oPromocodes = $oPromoUser->promocodes;
        $this->assertNotEmpty($oPromocodes);

        $oPromoCode = Promocode::whereNotIn('id', $oPromocodes->pluck('id'))->first();
        $this->assertNotNull($oPromoCode);

        DB::transaction(function () use ($oPromoUser, $oPromoCode) {
            $service = (new PromoUserService($oPromoUser));
            $result = $service->deactivatePromocode($oPromoCode);
            $this->assertFalse($result, 'Deactivate by isset promocode, must be false');
            DB::rollBack();
        });
    }
}
