<?php

namespace Tests\Unit\Services;

use App\Models\Promocode;
use App\Models\PromoUser;
use App\Services\PromocodeService;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * Class for promocode service test.
 */
class PromocodeServiceTest extends TestCase
{
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /**
     * Сервис
     *
     * @return PromocodeService
     */
    private function service(): PromocodeService
    {
        return new PromocodeService();
    }

    /**
     * Создание
     */
    public function testCreate()
    {
        $oService = $this->service();
        $countBefore = Promocode::count();

        DB::transaction(function () use ($oService, $countBefore) {
            $oPromocode = $oService->create([
                'promocode' => str_random(10)
            ]);
            $this->assertNotNull($oPromocode);
            $countAfter = Promocode::count();
            $this->assertTrue($countAfter > $countBefore);
            DB::rollBack();
        });
    }

    /**
     * Обновление
     */
    public function testUpdate()
    {
        $oService = $this->service();

        $oPromoCode = Promocode::first();
        $this->assertNotNull($oPromoCode, $this->textRed('Таблица promocodes пуста'));

        DB::transaction(function () use ($oService, $oPromoCode) {
            $promocode = $oPromoCode->promocode;
            $oPromocode = $oService->update($oPromoCode->id, [
                'promocode' => str_random(10)
            ]);
            $this->assertTrue($promocode !== $oPromocode->promocode);
            DB::rollBack();
        });
    }

    /**
     * Удаленик
     */
    public function testDestroy()
    {
        $oService = $this->service();

        $oPromoCode = Promocode::first();
        $this->assertNotNull($oPromoCode, $this->textRed('Таблица promocodes пуста'));
        $countBefore = Promocode::count();

        DB::transaction(function () use ($oService, $oPromoCode, $countBefore) {
            $oService->destroy($oPromoCode->id);
            $countAfter = Promocode::count();
            $this->assertTrue($countAfter < $countBefore);
            DB::rollBack();
        });
    }

    /**
     * Поиск активного промокода через сервис
     */
    public function testFind()
    {
        $oService = $this->service();
        $oPromoCode = Promocode::where('active', 1)->first();

        $this->assertNotNull($oService->findById($oPromoCode->id));
        $this->assertNotNull($oService->findByCode($oPromoCode->promocode));
    }

    /**
     * Проверка на просроченность промокода
     */
    public function testCheckExceptionsReleaseEnd()
    {
        $oService = $this->service();
        $oPromoCode = Promocode::where('release_end', '<', now())->first();

        $this->assertNotNull($oPromoCode);

        DB::transaction(function () use ($oService, $oPromoCode) {
            $result = $oService->checkPromocodeBeforeActivate($oPromoCode);
            $this->assertFalse($result, $this->textRed('Не прошла проверка просроченности промокода'));
            DB::rollBack();
        });
    }

    /**
     * Проверка на used = limit промокода
     */
    public function testCheckExceptionsUsedEqualLimit()
    {
        $oService = $this->service();

        $oPromoCode = Promocode::where('release_end', '>', now())
            ->where('used', 1)
            ->where('limit', 1)
            ->first();

        $this->assertNotNull($oPromoCode);

        DB::transaction(function () use ($oService, $oPromoCode) {
            $result = $oService->checkPromocodeBeforeActivate($oPromoCode);
            $this->assertFalse($result, $this->textRed('Не прошла проверка просроченности промокода'));
            DB::rollBack();
        });
    }

    /**
     * Активация промокода
     */
    public function testActivatePromocode()
    {
        $oService = $this->service();

        $oPromoUser = PromoUser::first();
        $this->assertNotNull($oPromoUser);

        $oPromoCode = Promocode::whereNotIn('id', $oPromoUser->promocodes->pluck('id')->toArray())->first();
        $this->assertNotNull($oPromoCode);

        DB::transaction(function () use ($oService, $oPromoCode, $oPromoUser) {
            $countBefore = $oPromoUser->promocodes->count();
            $usedBefore = $oPromoCode->used;

            $result = $oService->activatePromocode($oPromoCode, $oPromoUser);
            $this->assertTrue($result);

            $oPromoUser = PromoUser::first();
            $countAfter = $oPromoUser->promocodes->count();
            $usedAfter = $oPromoCode->used;

            $this->assertTrue($usedAfter > $usedBefore);
            $this->assertTrue($countAfter > $countBefore);

            DB::rollBack();
        });
    }

    /**
     * Деактивация промокода
     */
    public function testDeactivatePromocode()
    {
        $oService = $this->service();

        $oPromoUser = PromoUser::first();
        $this->assertNotNull($oPromoUser);

        $oPromoCode = Promocode::whereNotIn('id', $oPromoUser->promocodes->pluck('id')->toArray())->first();
        $this->assertNotNull($oPromoCode);

        DB::transaction(function () use ($oService, $oPromoCode, $oPromoUser) {
            $countBefore = $oPromoUser->promocodes->count();
            $usedBefore = $oPromoCode->used;

            $result = $oService->activatePromocode($oPromoCode, $oPromoUser);
            $this->assertTrue($result);

            $oPromoUser = PromoUser::first();

            $usedAfter = $oPromoCode->used;
            $this->assertTrue($usedAfter > $usedBefore);

            $countAfter = $oPromoUser->promocodes->count();
            $this->assertTrue($countAfter > $countBefore);

            $result = $oService->deactivatePromocode($oPromoCode, $oPromoUser);
            $this->assertTrue($result);

            $oPromoUser = PromoUser::first();
            $countAfterDeactivate = $oPromoUser->promocodes->count();
            $this->assertTrue($countAfterDeactivate < $countAfter);

            DB::rollBack();
        });
    }
}
