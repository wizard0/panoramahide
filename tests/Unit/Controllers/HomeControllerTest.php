<?php
/**
 * Copyright (c) 2018-2019 "ИД Панорама"
 * Автор модуля: Дмитрий Поскачей (dposkachei@gmail.com)
 */

namespace Tests\Unit\Controllers;

use App\Http\Controllers\HomeController;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\FactoryTrait;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use DatabaseTransactions;
    use FactoryTrait;

    /**
     * Тестирование домашней страницы
     */
    public function testIndex()
    {
        $oController = new HomeController();
        $result = $oController->index();

        $this->assertTrue($result instanceof \Illuminate\View\View);
    }

    /**
     * Тестирование страницы журналы
     */
    public function testJournals()
    {
        $promocode = $this->factoryPromocode();
        $user = $this->factoryUser();
        $promoUser = $this->factoryPromoUser([
            'user_id' => $user->id,
        ]);

        $promoUser->promocodes()->attach($promocode->id);
        $this->actingAs($user);

        $oController = new HomeController();
        $result = $oController->journals();
        $this->assertTrue($result instanceof \Illuminate\View\View);
    }
}
