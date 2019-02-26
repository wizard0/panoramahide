<?php

namespace Tests\Unit\Controllers;


use App\Http\Controllers\PromoController;
use App\Models\Promocode;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PromoControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testIndex()
    {
        $oController = new PromoController();

        $result = $oController->index();

        $this->assertTrue($result instanceof \Illuminate\View\View);
    }

    public function testDeskbooksGuest()
    {
        $oController = new PromoController();

        $request = $this->request();

        $result = $oController->deskbooks($request);

        $this->assertTrue($result instanceof \Illuminate\View\View);
    }

    /**
     * Запрос несуществующего промокода
     */
    public function testAccessWrongPromocode()
    {
        $oPromoController = (new PromoController());

        $request = $this->request([
            'promocode' => $this->promocode(), // несуществующий промокод
        ]);

        $result = $oPromoController->access($request);

        $this->assertFalse($result['success']);
    }

    /**
     * Запрос несуществующего промокода
     */
    public function testAccessPromocodeUser()
    {
        $oPromoController = (new PromoController());
        $request = new Request();

        $oPromoCode = $this->activePromocode();

        $this->assertNotNull($oPromoCode, $this->textRed('Активный промокод не найден'));

        $user = $this->user();

        // авторизация
        $this->actingAs($user);
        $this->assertAuthenticated();


        $oPromoCode->update([
            'release_end' => now()->subDay(),
        ]);
        $request->merge([
            'promocode' => $oPromoCode->promocode, // существующий промокод
            'phone' => $user->phone
        ]);

        $result = $oPromoController->access($request);

        $this->assertFalse($result['success']);

        $oPromoCode->update([
            'release_end' => now()->addDay(),
        ]);
        $request->merge([
            'promocode' => $oPromoCode->promocode, // существующий промокод
            'phone' => $user->phone
        ]);

        // полуение кода подтверждения
        DB::transaction(function () use ($oPromoController, $request) {
            $result = $oPromoController->access($request);
            $this->assertTrue($result['success']);

            $this->assertIsInt($result['code']);

            DB::rollBack();
        });
    }

    /**
     * Запрос несуществующего промокода
     */
    public function testAccessPromocodeGuest()
    {
        $oPromoController = (new PromoController());
        $request = new Request();

        $oPromoCode = $this->activePromocode();

        $this->assertNotNull($oPromoCode, $this->textRed('Активный промокод не найден'));

        $user = $this->user();

        // вывод модального окна с просьбой авторизоваться
        $request->merge([
            'promocode' => $oPromoCode->promocode, // существующий промокод
            'email' => $user->email,
        ]);
        $result = $oPromoController->access($request);

        $this->assertFalse($result['success']);

        $this->assertTrue($result['result'] === 2, $this->textRed('Пользователь не найден'));

        $request->merge([
            'promocode' => $oPromoCode->promocode, // существующий промокод
            'email' => $this->email(), // неверный email
            'phone' => $user->phone, // упадет ошибка потому что не уникальный
        ]);

        $result = $oPromoController->access($request);

        $this->assertTrue($result->getStatusCode() === 422, $this->textRed('Пользователь был найден или телефон уникальный'));

        $request->merge([
            'promocode' => $oPromoCode->promocode, // существующий промокод
            'email' => $this->email(), // неверный email
            'phone' => $this->phone(), // неверный телефон, уникальный
        ]);
        // полуение кода подтверждения
        DB::transaction(function () use ($oPromoController, $request) {
            $result = $oPromoController->access($request);

            $this->assertTrue($result['success']);

            $this->assertIsInt($result['code'], $this->textRed('Не сгенерирован код подтверждения'));

            DB::rollBack();
        });
    }
    /**
     * - проверка несуществующего промокода
     * - проверка неверного кода подтверждения по телефону
     */
    public function testCodeWrongCode()
    {
        $oPromoController = (new PromoController());

        $request = $this->request([
            'promocode' => $this->promocode(), // несуществующий промокод
        ]);
        $result = $oPromoController->code($request);
        $this->assertFalse($result['success']);

        $oPromoCode = $this->activePromocode();

        $request = $this->request([
            'promocode' => $oPromoCode->promocode, // существующий промокод
            'phone' => $this->phone(), // несуществующий телефон
            'code' => $this->promocode(), // несуществующий код подтверждения
        ]);

        $result = $oPromoController->code($request);

        $this->assertTrue($result->getStatusCode() === 422);

        $this->assertFalse(json_decode($result->getContent(), true)['success']);


        // полуение кода подтверждения
        DB::transaction(function () use ($oPromoController, $request, $oPromoCode) {

            $user = $this->user();
            // авторизация
            $this->actingAs($user);
            $this->assertAuthenticated();

            $result = $oPromoController->access($request);

            $this->assertTrue($result['success']);

            $this->assertIsInt($result['code']);

            $request = $this->request([
                'promocode' => $oPromoCode->promocode, // существующий промокод
                'phone' => $this->phone(), // несуществующий телефон
                'code' => $result['code'], // существующий код подтверждения
            ]);
            $result = $oPromoController->code($request);

            $this->assertTrue($result['success']);
            DB::rollBack();
        });


    }

    /**
     * - проверка несуществующего промокода перед входом
     * - проверка неверного кода подтверждения по телефону
     */
    public function testPasswordWrongPassword()
    {
        $oPromoController = (new PromoController());

        $request = new Request();
        $request->merge([
            'promocode' => $this->promocode(), // несуществующий промокод
        ]);

        $oPromoCode = $this->activePromocode();

        $request->merge([
            'promocode' => $oPromoCode->promocode, // несуществующий промокод
            'email' => $this->email(), // несуществующий email
            'password' => '1234567890',
        ]);

        $result = $oPromoController->password($request);

        $this->assertFalse($result['success']);
    }

    /**
     * - проверка несуществующего промокода перед входом
     * - проверка неверного кода подтверждения по телефону
     */
    public function testPasswordCorrectPassword()
    {
        $oPromoController = (new PromoController());

        $request = $this->request([
            'promocode' => $this->promocode(), // несуществующий промокод
        ]);

        $result = $oPromoController->password($request);

        $this->assertFalse($result['success']);

        $oPromoCode = $this->activePromocode();

        $request = $this->request([
            'promocode' => $oPromoCode->promocode, // существующий промокод
            'email' => testData()->user['email'], // существующий email
            'password' => testData()->user['password_string'],
        ]);

        $result = $oPromoController->password($request);

        $this->assertTrue($result['success']);
    }

    /**
     * Запрос несуществующего промокода для активации
     */
    public function testActivationWrongActivation()
    {
        $oPromoController = (new PromoController());

        $request = new Request();
        $request->merge([
            'promocode' => $this->promocode(), // несуществующий промокод
        ]);
        $result = $oPromoController->activation($request);

        $this->assertFalse($result['success']);
    }

    /**
     * Запрос несуществующего промокода для активации
     */
    public function testActivationCorrectActivation()
    {
        $oPromoController = (new PromoController());

        $request = $this->request([
            'promocode' => $this->activePromocode()->promocode, // существующий промокод
            'name' => testData()->user['name'],
        ]);

        // авторизация
        $this->actingAs($this->user());

        $result = $oPromoController->activation($request);

        $this->assertTrue($result['success']);
    }

    /**
     * Создание нового промо-пользователя
     */
    public function testActivationCorrectActivationNewUser()
    {
        $oPromoController = (new PromoController());

        $request = $this->request([
            'promocode' => $this->activePromocode()->promocode, // существующий промокод
            'name' => testData()->user['name'],
        ]);

        // авторизация
        $this->actingAs(User::create([
            'name' => testData()->user['name'],
            'last_name' => testData()->user['name'],
            'email' => 'second'.testData()->user['email'],
            'phone' => testData()->user['phone_second'],
            'password' => testData()->user['password'],
        ]));

        $result = $oPromoController->activation($request);

        $this->assertTrue($result['success']);
    }

    /**
     * Не активный промокод
     */
    public function testActivationCorrectActivationNotActivePromocode()
    {
        $oPromoController = (new PromoController());

        $request = $this->request([
            'promocode' => $this->notActivePromocode()->promocode, // не активный промокод
        ]);

        // авторизация
        $this->actingAs($this->user());

        $result = $oPromoController->activation($request);

        $this->assertFalse($result['success']);
    }


    public function testDeskbooksSave()
    {
        $oPromoController = (new PromoController());

        $user = $this->user();
        // авторизация
        $this->actingAs($user);
        $this->assertAuthenticated();

        $request = $this->request([
            'promocode' => $this->activePromocode()->id,
        ]);

        $oGroups = $oPromoController->deskbooks($request)['oGroups'];

        $request = $this->request([

        ]);

        $oGroups = $oPromoController->deskbooks($request)['oGroups'];

        $oJournal = collect([]);

        foreach ($oGroups as $oGroup) {
            $oJournal = $oGroup->journals->first();
        }

        $this->assertNotNull($oJournal);

        $oPromocode = $this->activePromocode();

        $this->assertNotNull($oPromocode);

        $aJournalPromocode[] = $oJournal->id.'::'.$oPromocode->id;

        $request = new Request();
        $request->merge([
            'journal::promocode' => $aJournalPromocode,
        ]);

        // полуение кода подтверждения
        DB::transaction(function () use ($oPromoController, $request, $oJournal) {

            $result = $oPromoController->save($request);

            $this->assertTrue($result['success']);

            DB::rollBack();
        });
    }


    /**
     * Активный промокод
     * - release_end > now()
     * - active = 1
     * - used < limit
     *
     * @return mixed
     */
    private function activePromocode()
    {
        $oPromoCodes = Promocode::where('release_end', '>', now())
            ->where('active', 1)
            ->get();
        $oPromoCodes = $oPromoCodes->reject(function ($item) {
            return $item->used >= $item->limit;
        });
        return $oPromoCodes->first();
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
        $oPromoCodes = Promocode::where('release_end', '>', now())
            ->where('active', 1)
            ->get();
        $oPromoCodes = $oPromoCodes->reject(function ($item) {
            return $item->used < $item->limit;
        });
        return $oPromoCodes->first();
    }

    /**
     * Тестовый пользователь
     *
     * @return mixed
     */
    private function user() : User
    {
        return testData()->user();
    }

    /**
     * Неверный телефон
     *
     * @return int
     */
    private function phone() : int
    {
        return 79998887777; // тестовый 79998887766
    }

    /**
     * Неверный промокод
     *
     * @return string
     */
    private function promocode() : string
    {
        return '2--------2';
    }

    /**
     * Не существующий email
     *
     * @return string
     */
    private function email() : string
    {
        return 'user_wrong@user.com';
    }
}
