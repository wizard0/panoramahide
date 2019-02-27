<?php

namespace Tests\Unit\Services;


use App\Models\PromoUser;
use App\Models\Promocode;
use App\Services\PromoUserService;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PromoUserServiceTest extends TestCase
{
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
        $this->user = $this->createUser();

        $this->promoUser = factory(PromoUser::class)->create([
            'user_id' => $this->user->id,
        ]);
    }

    /**
     * @return PromoUserService
     */
    private function service(): PromoUserService
    {
        return new PromoUserService($this->promoUser());
    }

    /**
     * @return PromoUser
     */
    private function promoUser(): PromoUser
    {
        return PromoUser::find($this->promoUser->id);
    }

    /**
     * Создание промо-пользователя
     */
    public function testCreate()
    {
        $oPromoUser = $this->service()->create([
            'name' => 'Промо пользовтаель',
            'user_id' => $this->user->id,
            'phone' => testData()->user['phone'],
        ]);
        $this->assertNotNull($oPromoUser);
    }

    /**
     * Обновление промо пользователя
     */
    public function testUpdate()
    {
        $oPromoUser = $this->service()->update($this->promoUser()->id, [
            'name' => 'Промо пользовтаель',
            'phone' => testData()->user['phone'],
        ]);
        $this->assertTrue($oPromoUser->name === 'Промо пользовтаель');
    }

    /**
     * Проверка на просроченность промокода
     */
    public function testCheckExceptionsReleaseEnd()
    {
        $oPromoCode = factory(Promocode::class)->create([
            'release_end' => now()->subDay(),
            'limit' => 10,
            'used' => 1,
        ]);

        $service = $this->service();
        $result = $service->activatePromocode($oPromoCode);
        $this->assertFalse($result);
        $this->assertTrue($service->getMessage() !== null);
    }

    /**
     * Активация существующего промокода
     */
    public function testCheckExceptionsActivateExists()
    {
        $oPromoCode = factory(Promocode::class)->create([
            'type' => 'on_release',
            'release_end' => now()->addDay(),
            'limit' => 10,
            'used' => 1,
            'release_limit' => 1,
        ]);

        $this->assertTrue(count($this->promoUser()->promocodes) === 0);

        $result = $this->service()->activatePromocode($oPromoCode);

        $this->assertTrue($result);

        $this->assertTrue(count($this->promoUser()->promocodes) !== 0);

        $result = $this->service()->activatePromocode($oPromoCode);
        $this->assertFalse($result);
    }

    /**
     * Деактивация не существовующего промокода
     */
    public function testCheckExceptionsDeactivateNotExists()
    {
        $oPromoCode = factory(Promocode::class)->create([
            'type' => 'on_release',
            'release_end' => now()->addDay(),
            'limit' => 10,
            'used' => 1,
        ]);

        $result = $this->service()->activatePromocode($oPromoCode);
        $this->assertTrue($result);

        $this->assertNotEmpty($this->promoUser()->promocodes);

        $oPromoCode = factory(Promocode::class)->create([
            'type' => 'on_release',
            'release_end' => now()->addDay(),
            'limit' => 10,
            'used' => 1,
        ]);
        $this->assertNotNull($oPromoCode);

        $result = $this->service()->deactivatePromocode($oPromoCode);
        $this->assertFalse($result);
    }

    /**
     * Активирование активированного промокода
     */
    public function testActivateActivePromocode()
    {
        $oPromoCode = factory(Promocode::class)->create([
            'type' => 'on_release',
            'release_end' => now()->addDay(),
            'limit' => 10,
            'used' => 9,
            'release_limit' => 1,
        ]);

        $result = $this->service()->activatePromocode($oPromoCode);
        $this->assertTrue($result);

        $result = $this->service()->activatePromocode($oPromoCode);
        $this->assertFalse($result);
    }

    /**
     * Деактивация не существовующего промокода
     */
    public function testDeactivatePromocode()
    {
        $oPromoCode = factory(Promocode::class)->create([
            'type' => 'on_release',
            'release_end' => now()->addDay(),
            'limit' => 10,
            'used' => 1,
        ]);

        $result = $this->service()->activatePromocode($oPromoCode);
        $this->assertTrue($result);

        $this->assertNotEmpty($this->promoUser()->promocodes);

        $result = $this->service()->deactivatePromocode($oPromoCode);
        $this->assertTrue($result);
    }

    /**
     * @covers \App\Services\PromoUserService::codeGenerateByPhone()
     */
    public function testCodeGenerateByPhone()
    {
        // когда кода нет в активации
        $code = $this->service()->codeGenerateByPhone($this->user->phone);
        $this->assertIsInt($code);

        // когда код есть в активации, с последующим удалением всех остальных
        $code = $this->service()->codeGenerateByPhone($this->user->phone);
        $this->assertIsInt($code);
    }

    /**
     * @covers \App\Services\PromoUserService::codeCheckByPhone()
     */
    public function testCodeCheckByPhone()
    {
        // когда кода нет в активации
        $code = $this->service()->codeGenerateByPhone($this->user->phone);
        $this->assertIsInt($code);

        // изменение кода и сохранение int
        $wrongCode = $code + 1;

        // неверный код
        $result = $this->service()->codeCheckByPhone($this->user->phone, $wrongCode);
        $this->assertFalse($result);

        // успешная активаци
        $result = $this->service()->codeCheckByPhone($this->user->phone, $code);
        $this->assertTrue($result);
    }
}
