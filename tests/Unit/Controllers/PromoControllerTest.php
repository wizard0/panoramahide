<?php
/**
 * @copyright Copyright (c) 2018-2019 "ИД Панорама"
 * @author    Дмитрий Поскачей (dposkachei@gmail.com)
 */

namespace Tests\Unit\Controllers;

use App\Http\Controllers\PromoController;
use App\Models\Activations;
use App\Models\Promocode;
use App\Models\PromoUser;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tests\FactoryTrait;
use Tests\TestCase;

/**
 * Class for promo controller test.
 */
class PromoControllerTest extends TestCase
{
    use DatabaseTransactions;
    use FactoryTrait;

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
     * @return PromoController
     */
    public function controller(): PromoController
    {
        return new PromoController();
    }

    /**
     *
     */
    public function testIndex()
    {
        $result = $this->controller()->index();
        $this->assertTrue($result instanceof \Illuminate\View\View);
    }

    /**
     *
     */
    public function testDeskbooksGuest()
    {
        $request = $this->request();
        $result = $this->controller()->deskbooks($request);
        $this->assertTrue($result instanceof \Illuminate\View\View);
    }

    /**
     * Запрос несуществующего промокода
     */
    public function testAccessWrongPromocode()
    {
        $result = $this->controller()->access($this->request([
            'promocode' => $this->promocode(), // несуществующий промокод
        ]));
        $this->assertFalse($result['success']);
    }

    /**
     * Запрос несуществующего промокода
     */
    public function testAccessPromocodeUser()
    {
        $this->actingAs($this->user());
        $this->assertAuthenticated();

        // неактивный промокод
        $result = $this->controller()->access($this->request([
            'promocode' => $this->notActivePromocode()->promocode,
            'phone' => $this->phone(),
        ]));
        $this->assertFalse($result['success']);

        // активный промокод
        $result = $this->controller()->access($this->request([
            'promocode' => $this->activePromocode()->promocode,
            'phone' => $this->phone(),
        ]));
        $this->assertTrue($result['success']);
        $this->assertIsInt($result['code']);
    }

    /**
     * Запрос несуществующего промокода
     */
    public function testAccessPromocodeGuest()
    {
        $oPromocode = $this->activePromocode();
        // вывод модального окна с просьбой авторизоваться
        $result = $this->controller()->access($this->request([
            'promocode' => $oPromocode->promocode,
            'email' => $this->user()->email,
        ]));
        $this->assertFalse($result['success']);
        $this->assertTrue($result['result'] === 2);

        $result = $this->controller()->access($this->request([
            'promocode' => $oPromocode->promocode,
            'email' => $this->email(), // неверный email
            'phone' => $this->user()->phone,
        ]));
        $this->assertTrue($result->getStatusCode() === 422);

        // полуение кода подтверждения
        $result = $this->controller()->access($this->request([
            'promocode' => $oPromocode->promocode, // существующий промокод
            'email' => $this->email(), // неверный email
            'phone' => $this->phone(), // неверный телефон, уникальный
        ]));
        $this->assertTrue($result['success']);
        $this->assertIsInt($result['code']);
    }

    /**
     * - проверка несуществующего промокода
     * - проверка неверного кода подтверждения по телефону
     */
    public function testCodeWrongCode()
    {
        // несуществующий промокод
        $result = $this->controller()->code($this->request([
            'promocode' => $this->promocode(),
        ]));
        $this->assertFalse($result['success']);

        // существующий промокод, неверный код подтверждения
        $oPromoCode = $this->activePromocode();
        $result = $this->controller()->code($this->request([
            'promocode' => $oPromoCode->promocode,
            'phone' => $this->phone(),
            'code' => $this->code(),
        ]));
        $this->assertTrue($result->getStatusCode() === 422);
        $this->assertFalse(json_decode($result->getContent(), true)['success']);

        // полуение кода подтверждения
        // авторизация
        $this->actingAs($this->user());
        $this->assertAuthenticated();

        // запрос кода подтверждения
        $result = $this->controller()->access($this->request([
            'promocode' => $oPromoCode->promocode,
            'phone' => $this->user()->phone,
        ]));
        $this->assertTrue($result['success']);
        $this->assertIsInt($result['code']);
        $code = $result['code'];

        // активация кода
        $result = $this->controller()->code($this->request([
            'promocode' => $oPromoCode->promocode,
            'phone' => $this->user()->phone,
            'code' => $code,
        ]));
        $this->assertTrue($result['success']);
    }

    /**
     * Код для нового пользователя
     */
    public function testCodeGuestNewUser()
    {
        $oPromoCode = $this->activePromocode();

        $phone = $this->phone();
        // запрос кода подтверждения для нового пользователя
        $result = $this->controller()->access($this->request([
            'promocode' => $oPromoCode->promocode,
            'phone' => $phone,
        ]));
        $this->assertTrue($result['success']);
        $this->assertIsInt($result['code']);

        $code = $result['code'];
        // код с email
        $result = $this->controller()->code($this->request([
            'promocode' => $oPromoCode->promocode,
            'phone' => $phone,
            'code' => $code,
            'email' => $this->email(),
        ]));
        $this->assertTrue($result['success']);
    }

    /**
     * Код для существующего пользователя
     */
    public function testCodeGuestIssetUser()
    {
        $oPromoCode = $this->activePromocode();

        $phone = $this->phone();
        // активация кода новым пользователем
        $result = $this->controller()->access($this->request([
            'promocode' => $oPromoCode->promocode,
            'phone' => $phone,
            'code' => $this->promocode(),
        ]));

        $this->assertTrue($result['success']);
        $this->assertIsInt($result['code']);

        $code = $result['code'];
        // активация кода новым пользователем
        $result = $this->controller()->code($this->request([
            'promocode' => $oPromoCode->promocode,
            'phone' => $phone,
            'code' => $code,
            'email' => $this->user()->email,
        ]));
        $this->assertTrue($result['success']);
    }


    /**
     * - проверка несуществующего промокода перед входом
     * - проверка неверного кода подтверждения по телефону
     */
    public function testPasswordWrongPassword()
    {
        $oPromoCode = $this->activePromocode();
        $result = $this->controller()->password($this->request([
            'promocode' => $oPromoCode->promocode, // несуществующий промокод
            'email' => $this->email(), // несуществующий email
            'password' => '1234567890',
        ]));
        $this->assertFalse($result['success']);
    }

    /**
     * - проверка несуществующего промокода перед входом
     * - проверка неверного кода подтверждения по телефону
     */
    public function testPasswordCorrectPassword()
    {
        $result = $this->controller()->password($this->request([
            'promocode' => $this->promocode(), // несуществующий промокод
        ]));
        $this->assertFalse($result['success']);

        $oPromoCode = $this->activePromocode();
        $result = $this->controller()->password($this->request([
            'promocode' => $oPromoCode->promocode, // существующий промокод
            'email' => $this->user()->email, // существующий email
            'password' => 'secret',
        ]));
        $this->assertTrue($result['success']);
    }

    /**
     * Запрос несуществующего промокода для активации
     */
    public function testActivationWrongActivation()
    {
        $result = $this->controller()->activation($this->request([
            'promocode' => $this->promocode(), // несуществующий промокод
        ]));
        $this->assertFalse($result['success']);
    }

    /**
     * Запрос несуществующего промокода для активации
     */
    public function testActivationCorrectActivation()
    {
        // авторизация
        $this->actingAs($this->user());
        $result = $this->controller()->activation($this->request([
            'promocode' => $this->activePromocode()->promocode, // существующий промокод
            'name' => 'secret',
        ]));
        $this->assertTrue($result['success']);
    }

    /**
     * Создание нового промо-пользователя
     */
    public function testActivationCorrectActivationNewUser()
    {
        // авторизация
        $this->actingAs($this->factoryUser());

        $result = $this->controller()->activation($this->request([
            'promocode' => $this->activePromocode()->promocode, // существующий промокод
            'name' => 'Test',
        ]));
        $this->assertTrue($result['success']);
    }

    /**
     * Не активный промокод
     */
    public function testActivationCorrectActivationNotActivePromocode()
    {
        // авторизация
        $this->actingAs($this->user());
        $result = $this->controller()->activation($this->request([
            'promocode' => $this->notActivePromocode()->promocode, // не активный промокод
        ]));
        $this->assertFalse($result['success']);
    }

    /**
     * Закладки
     */
    public function testDeskbooksSave()
    {
        $oPromocode = $this->activePromocode([
            'type' => Promocode::TYPE_CUSTOM,
        ]);

        $oJournal = $this->factoryJournal();

        $oGroup = $this->factoryGroup([
            'active' => true,
            'promocode_id' => $oPromocode->id,
        ]);

        $oGroup->journals()->attach($oJournal->id);

        // авторизация
        $this->actingAs($this->user());
        $this->assertAuthenticated();

        $oGroups = $this->controller()->deskbooks($this->request([
            'promocode' => $oPromocode->id,
        ]))['oGroups'];

        $oJournal = collect([]);
        foreach ($oGroups as $oGroup) {
            $oJournal = $oGroup->journals->first();
        }
        $this->assertNotNull($oJournal);


        $aJournalPromocode[] = $oJournal->id . '::' . $oPromocode->id;
        // полуение кода подтверждения
        $result = $this->controller()->save($this->request([
            'journal::promocode' => $aJournalPromocode,
        ]));
        $this->assertTrue($result['success']);
    }

    /**
     * Активный промокод
     * - release_end > now()
     * - active = 1
     * - used < limit
     *
     * @param array $data
     * @return mixed
     */
    private function activePromocode(array $data = [])
    {
        return $this->factoryPromocode(array_merge($data, [
            'release_end' => now()->addDay(),
            'active' => 1,
            'used' => 0,
            'limit' => 10,
        ]));
    }

    /**
     * Не активный промокод
     * - release_end > now()
     * - active = 1
     * - used < limit
     *
     * @return mixed
     */
    private function notActivePromocode()
    {
        return $this->factoryPromocode([
            'release_end' => now()->subDay(),
            'active' => 1,
            'used' => 0,
            'limit' => 3,
        ]);
    }

    /**
     * Тестовый пользователь
     *
     * @return mixed
     */
    private function user(): User
    {
        return $this->user;
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

    /**
     * Неверный промокод
     *
     * @return string
     */
    private function promocode(): string
    {
        return $this->factoryMake(Promocode::class)->promocode;
    }

    /**
     * Не существующий email
     *
     * @return string
     */
    private function email(): string
    {
        return $this->factoryMake(User::class)->email;
    }

    /**
     * @return int
     */
    private function code(): int
    {
        return $this->factoryMake(Activations::class)->code;
    }
}
