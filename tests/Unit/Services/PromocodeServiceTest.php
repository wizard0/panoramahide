<?php
/**
 * @copyright Copyright (c) 2018-2019 "ИД Панорама"
 * @author Дмитрий Поскачей (dposkachei@gmail.com)
 */

namespace Tests\Unit\Services;

use App\Models\Promocode;
use App\Models\PromoUser;
use App\Services\PromocodeService;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\FactoryTrait;
use Tests\TestCase;

/**
 * Class for promocode service test.
 */
class PromocodeServiceTest extends TestCase
{
    use FactoryTrait;
    use DatabaseTransactions;

    /**
     * @var User
     */
    private $user;

    /**
     * @var PromoUser
     */
    private $promoUser;

    /**
     *
     */
    protected function setUp()
    {
        parent::setUp();
        $this->user = $this->factoryUser();

        $this->promoUser = factory(PromoUser::class)->create([
            'user_id' => $this->user->id,
        ]);
    }

    /**
     * @return PromoUser
     */
    private function promoUser(): PromoUser
    {
        return PromoUser::find($this->promoUser->id);
    }

    /**
     * @param Promocode|null $promocode
     * @return PromocodeService
     */
    private function service(Promocode $promocode = null): PromocodeService
    {
        return new PromocodeService($promocode);
    }

    /**
     * @covers \App\Services\PromocodeService::redirectsByType()
     */
    public function testRedirectsByType()
    {
        $oPromocode = $this->factoryPromocode([
            'type' => Promocode::TYPE_ON_JOURNAL,
            'release_end' => now()->addDay(),
            'used' => 0,
            'limit' => 10,
        ]);
        $service = $this->service($oPromocode);
        $this->assertTrue($service->redirectsByType() === route('home.journals'));

        $oPromocode = $this->factoryPromocode([
            'type' => Promocode::TYPE_CUSTOM,
            'release_end' => now()->addDay(),
            'used' => 0,
            'limit' => 10,
        ]);
        $service = $this->service($oPromocode);
        $this->assertTrue($service->redirectsByType() === route('deskbooks.index', [
            'promocode' => $oPromocode->id
        ]));
    }

    /**
     * @covers \App\Services\PromocodeService::promoUser()
     */
    public function testSetAuthPromoUser()
    {
        $service = $this->service();
        $this->actingAs($this->user);

        $oPromoUser = $service->promoUser();
        $this->assertTrue($oPromoUser->id === $this->promoUser()->id);
    }

    /**
     * Создание
     */
    public function testCreate()
    {
        $countBefore = Promocode::count();

        $oPromocode = $this->service()->create([
            'promocode' => str_random(10)
        ]);
        $this->assertNotNull($oPromocode);
        $countAfter = Promocode::count();
        $this->assertTrue($countAfter > $countBefore);
    }

    /**
     * Обновление
     */
    public function testUpdate()
    {
        $oPromoCode = $this->factoryPromocode();

        $promocode = $oPromoCode->promocode;
        $oPromocode = $this->service()->update($oPromoCode->id, [
            'promocode' => str_random(10)
        ]);
        $this->assertTrue($promocode !== $oPromocode->promocode);
    }

    /**
     * Удаленик
     */
    public function testDestroy()
    {
        $oPromoCode = $this->factoryPromocode();

        $countBefore = Promocode::count();
        $this->service()->destroy($oPromoCode->id);
        $countAfter = Promocode::count();
        $this->assertTrue($countAfter < $countBefore);
    }

    /**
     * Поиск активного промокода через сервис
     */
    public function testFind()
    {
        $oPromoCode = $this->factoryPromocode([
            'active' => 1,
        ]);

        $this->assertNotNull($this->service()->findById($oPromoCode->id));
        $this->assertNotNull($this->service()->findByCode($oPromoCode->promocode));
    }

    /**
     * Проверка на просроченность промокода
     */
    public function testCheckExceptionsReleaseEnd()
    {
        $oPromoCode = $this->factoryPromocode([
            'release_end' => now()->subDay(),
        ]);

        $result = $this->service()->checkPromocodeBeforeActivate($oPromoCode);
        $this->assertFalse($result);
    }

    /**
     * Проверка на used = limit промокода
     */
    public function testCheckExceptionsUsedEqualLimit()
    {
        $oPromoCode = $this->factoryPromocode([
            'release_end' => now()->addDay(),
            'used' => 1,
            'limit' => 1,
        ]);

        $result = $this->service()->checkPromocodeBeforeActivate($oPromoCode);
        $this->assertFalse($result);
    }

    /**
     * Активация промокода
     */
    public function testActivatePromocode()
    {
        $oPromoCode = $this->factoryPromocode([
            'type' => Promocode::TYPE_ON_JOURNAL,
            'release_end' => now()->addDay(),
            'used' => 0,
            'limit' => 10,
        ]);

        $countBefore = $this->promoUser()->promocodes()->count();
        $usedBefore = $oPromoCode->used;

        $result = $this->service()->activatePromocode($oPromoCode, $this->promoUser());
        $this->assertTrue($result);

        $countAfter = $this->promoUser()->promocodes()->count();
        $usedAfter = $oPromoCode->used;

        $this->assertTrue($usedAfter > $usedBefore);
        $this->assertTrue($countAfter > $countBefore);
    }

    /**
     * Деактивация промокода
     */
    public function testDeactivatePromocode()
    {
        $oPromoCode = $this->factoryPromocode([
            'type' => Promocode::TYPE_ON_JOURNAL,
            'release_end' => now()->addDay(),
            'used' => 0,
            'limit' => 10,
        ]);

        $countBefore = $this->promoUser()->promocodes()->count();
        $usedBefore = $oPromoCode->used;

        $result = $this->service()->activatePromocode($oPromoCode, $this->promoUser());
        $this->assertTrue($result);

        $usedAfter = $oPromoCode->used;
        $this->assertTrue($usedAfter > $usedBefore);

        $countAfter = $this->promoUser()->promocodes()->count();
        $this->assertTrue($countAfter > $countBefore);

        $result = $this->service()->deactivatePromocode($oPromoCode, $this->promoUser());
        $this->assertTrue($result);

        $countAfterDeactivate = $this->promoUser()->promocodes()->count();
        $this->assertTrue($countAfterDeactivate < $countAfter);
    }
}
