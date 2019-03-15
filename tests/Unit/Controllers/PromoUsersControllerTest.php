<?php
/**
 * Copyright (c) 2018-2019 "ИД Панорама"
 * Автор модуля: Дмитрий Поскачей (dposkachei@gmail.com)
 */

namespace Tests\Unit\Controllers;

use App\Http\Controllers\PromoUsersController;
use App\Models\Promocode;
use App\Models\PromoUser;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\FactoryTrait;
use Tests\TestCase;

class PromoUsersControllerTest extends TestCase
{
    use DatabaseTransactions;
    use FactoryTrait;

    /**
     * @var User
     */
    private $user;

    /**
     * @var User
     */
    private $promoUser;

    /**
     * Создание сущностей
     */
    protected function setUp()
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->promoUser = factory(PromoUser::class)->create();
    }

    /**
     * @return User|null
     */
    public function user(): ?User
    {
        return User::find($this->user->id);
    }

    /**
     * @return PromoUser|null
     */
    public function promoUser(): ?PromoUser
    {
        return PromoUser::find($this->promoUser->id);
    }

    /**
     * @return PromoUsersController
     */
    public function controller(): PromoUsersController
    {
        return new PromoUsersController();
    }

    /**
     * Создание промо пользователя
     */
    public function testStore()
    {
        // Ajax запрос
        $request = $this->request([]);
        $result = $this->controller()->store($request);
        $this->assertFalse($result->getData()->success);

        // Валидация
        $request = $this->request([], true);
        $result = $this->controller()->store($request);
        $this->assertEquals($result->getStatusCode(), 422);

        // Создание промо пользователя
        $this->assertNull($this->user()->promo);
        $request = $this->request([
            'name' => $this->user->name,
            'user_id' => $this->user->id,
            'phone' => '' . $this->user->phone,
        ], true);
        $result = $this->controller()->store($request);
        $this->assertTrue($result['success']);
        $this->assertNotNull($this->user()->promoUser);
    }

    /**
     * Обновление промо пользователя
     */
    public function testUpdate()
    {
        $id = $this->promoUser()->id;

        // Ajax запрос
        $request = $this->request([]);
        $result = $this->controller()->update($request, $id);
        $this->assertFalse($result->getData()->success);

        // Валидация
        $request = $this->request([], true);
        $result = $this->controller()->update($request, $id);
        $this->assertEquals($result->getStatusCode(), 422);

        // Обновление промо пользователя
        $phone = $this->phone();
        $request = $this->request([
            'name' => $this->promoUser()->name,
            'phone' => '' . $phone,
        ], true);
        $result = $this->controller()->update($request, $id);
        $this->assertTrue($result['success']);
        $this->assertTrue((int)$this->promoUser()->phone === (int)$phone);
    }

    /**
     * Удаление промо пользователя
     */
    public function testDestroy()
    {
        $id = $this->promoUser()->id;

        // Ajax запрос
        $request = $this->request([]);
        $result = $this->controller()->destroy($request, $id);
        $this->assertFalse($result->getData()->success);

        // Удаление
        $request = $this->request([], true);
        $result = $this->controller()->destroy($request, $id);
        $this->assertTrue($result['success']);

        $this->assertNull($this->promoUser());
    }

    /**
     * Вывол промокодов
     */
    public function testPromocodes()
    {
        $id = $this->promoUser()->id;

        // активация
        $request = $this->request([], true);
        $result = $this->controller()->promocodes($request, $id);
        $this->assertTrue($result instanceof \Illuminate\View\View);
    }

    /**
     * Активация релизов
     */
    public function testActivatePromocode()
    {
        $id = $this->promoUser()->id;
        $oActivePromocode = factory(Promocode::class)->create([
            'type' => 'on_release',
            'release_end' => now()->addDay(),
            'limit' => 10,
            'used' => 1,
            'release_limit' => 1,
        ]);

        $oNotActivePromocode = factory(Promocode::class)->create([
            'type' => 'on_release',
            'release_end' => now()->addDay(),
            'limit' => 10,
            'used' => 10,
            'release_limit' => 1,
        ]);

        // Ajax запрос
        $request = $this->request([]);
        $result = $this->controller()->activatePromocode($request, $id, $oActivePromocode->id);
        $this->assertFalse($result->getData()->success);

        // активация не активного
        $request = $this->request([], true);
        $result = $this->controller()->activatePromocode($request, $id, $oNotActivePromocode->id);
        $this->assertEquals($result->getStatusCode(), 422);

        // активация
        $request = $this->request([], true);
        $result = $this->controller()->activatePromocode($request, $id, $oActivePromocode->id);
        $this->assertTrue($result['success']);
    }

    /**
     * Вывол публикаций
     */
    public function testPublishings()
    {
        $id = $this->promoUser()->id;

        // активация
        $request = $this->request([], true);
        $result = $this->controller()->publishings($request, $id);
        $this->assertTrue($result instanceof \Illuminate\View\View);
    }

    /**
     * Активация релизов
     */
    public function testActivatePublishing()
    {
        $id = $this->promoUser()->id;
        $item_id = 1;

        // Ajax запрос
        $request = $this->request([]);
        $result = $this->controller()->activatePublishing($request, $id, $item_id);
        $this->assertFalse($result->getData()->success);

        // активация
        $request = $this->request([], true);
        $result = $this->controller()->activatePublishing($request, $id, $item_id);
        $this->assertTrue($result['success']);
    }

    /**
     * Вывол релизов
     */
    public function testReleases()
    {
        $id = $this->promoUser()->id;

        // активация
        $request = $this->request([], true);
        $result = $this->controller()->releases($request, $id);
        $this->assertTrue($result instanceof \Illuminate\View\View);
    }

    /**
     * Активация релизов
     */
    public function testActivateRelease()
    {
        $id = $this->promoUser()->id;
        $item_id = 1;

        // Ajax запрос
        $request = $this->request([]);
        $result = $this->controller()->activateRelease($request, $id, $item_id);
        $this->assertFalse($result->getData()->success);

        // активация
        $request = $this->request([], true);
        $result = $this->controller()->activateRelease($request, $id, $item_id);
        $this->assertTrue($result['success']);
    }

    /**
     * Неверный телефон
     *
     * @return int
     */
    private function phone(): int
    {
        return $this->factoryMake(User::class)->phone;
    }
}
