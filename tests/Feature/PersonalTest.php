<?php
/**
 * @copyright
 * @author
 */
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Mail;
use Tests\FactoryTrait;
use App\Models\Journal;
use App\Models\Release;
use App\Models\Order;
use App\Models\Paysystem;
use App\Models\User;
use App\Models\Subscription;
use App\Models\Article;
use App\Cart;

class PersonalTest extends TestCase
{
    use DatabaseTransactions;
    use FactoryTrait;

    protected $user;
    protected $journal;
    protected $release;
    protected $p_data;
    protected $l_data;

    protected function setUp()
    {
        parent::setUp();
        $this->user = $this->factoryUser();
        $this->journal = factory(Journal::class)->create();
        $this->release = factory(Release::class)->create(['journal_id' => $this->journal->id]);
        // данные для заказа на физлицо
        $email = str_random(10) . '@mail.ru';
        $this->p_data = [
            'PERSON_TYPE' => Order::PHYSICAL_USER,
            'name'             => str_random(6),
            'surname'          => str_random(6),
            'patronymic'       => str_random(6),
            'phone'            => str_random(6),
            'email'            => $email,
            'delivery_address' => str_random(6),
            'paysystem_physic' => Paysystem::ROBOKASSA,
        ];
        // данные для заказа на юрлицо
        $email = str_random(10) . '@mail.ru';
        $this->l_data = [
            'PERSON_TYPE' => Order::LEGAL_USER,
            'l_name'             => str_random(6),
            'l_surname'          => str_random(6),
            'l_patronymic'       => str_random(6),
            'l_phone'            => str_random(6),
            'l_email'            => $email,
            'l_delivery_address' => str_random(6),
            'paysystem_legal'    => Paysystem::INVOICE,
        ];
    }

//    protected function tearDown()
//    {

//    }

    public function testIndex()
    {
        $response = $this->get(route('personal'));
        $response->assertStatus(302)
                 ->assertRedirect(route('personal.login', ['backTo' => route('personal')]));
        $this->actingAs($this->user);
        $response = $this->get(route('personal.login', ['backTo' => route('personal')]));
        $response->assertStatus(302)
                 ->assertRedirect(route('personal'));
        $response = $this->get(route('personal'));
        $response->assertStatus(200)
                 ->assertSee('personal-content');
    }

    public function testLogin()
    {
        $response = $this->get(route('personal.login'));
        $response->assertStatus(200)
                 ->assertSee('Авторизация');
        $this->actingAs($this->user);
        $response = $this->get(route('personal.login', ['backTo' => route('personal')]));
        $response->assertStatus(302)
                 ->assertRedirect(route('personal'));
    }

    public function testLogout()
    {
        $response = $this->get(route('logout'));
        $response->assertStatus(302)
                 ->assertRedirect(route('index'));
    }

    public function testEmptyPages()
    {
        $this->actingAs($this->user);
        $response = $this->get(route('personal.orders'));
        $response->assertStatus(200)
                 ->assertSee('_empty');

        $response = $this->get(route('personal.cart'));
        $response->assertStatus(200)
                 ->assertSee('_empty');

        $response = $this->get(route('personal.subscriptions'));
        $response->assertStatus(200)
                 ->assertSee('_empty');

        $response = $this->get(route('personal.magazines'));
        $response->assertStatus(200)
                 ->assertSee('_empty');
    }

    public function testWrongOrderPages()
    {
        $this->actingAs($this->user);
        $response = $this->get(route('personal.order', 1));
        $response->assertStatus(302);
    }

    public function testChangePassword()
    {
        $this->actingAs($this->user);
        // Проверяем смену пароля без данных
        $response = $this->post(route('personal.profile.password'));
        $response->assertStatus(422);
        // Указываем только текущий пароль
        $response = $this->post(route('personal.profile.password'), [
            'email' => $this->user->email,
            'password' => 'secret'
        ]);
        $response->assertStatus(422);
        // Указываем данные верно
        $response = $this->post(route('personal.profile.password'), [
            'email' => $this->user->email,
            'password' => 'secret',
            'new_password' => 'new_secret',
            'new_password_confirmation' => 'new_secret',
        ]);
        $response->assertStatus(200);
    }

    public function testProfile()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('personal.profile'));
        $response->assertStatus(200)
                 ->assertSee('profileForm')
                 ->assertSee('passwordForm');
    }

    public function testProfileUpdate()
    {
        $this->actingAs($this->user);
        // Пробуем обновить профиль с неверными данными
        $response = $this->postAjax(route('personal.profile'));
        $response->assertStatus(422);
        // Указываем данные для обновления профиля
        $data = [
            'gender' => 2,
            'version' => 'printed',
            'name' => 'NewName',
        ];
        $response = $this->postAjax(route('personal.profile'), $data);
        $response->assertStatus(200)
                 ->assertJson([
                    'success' => true,
                 ]);
    }
    // Добавляем журнал в корзину
    public function addToCart($q = 1)
    {
        if ($q >= 1) {
            $this->postAjax(route('cart.add'), [
                'id'      => $this->release->id,
                'type'    => Cart::PRODUCT_TYPE_RELEASE,
                'version' => Cart::VERSION_ELECTRONIC
            ]);
        }
        if ($q >= 2) {
            $subscription = factory(Subscription::class)->create([
                                'journal_id' => $this->journal->id,
                                'locale' => \App::getLocale(),
                                'half_year' => 'second',
                                'type' => Subscription::TYPE_PRINTED
                            ]);
            $this->release->active_date = '2019-03-03';
            $this->release->save();
            // Добавляем в корзину подписку на журнал
            $response = $this->postAjax(route('cart.add'), [
                'id'             => $subscription->id,
                'type'           => Cart::PRODUCT_TYPE_SUBSCRIPTION,
                'version'        => Cart::VERSION_PRINTED,
                'additionalData' => [
                    'type'         => Cart::PRODUCT_TYPE_SUBSCRIPTION,
                    'start_month'  => '201902',
                    'term'         => 12,
                    'single_price' => 100,
                    'journal_id'   => $this->journal->id,
                ],
            ]);
        }
        if ($q >= 3) {
            // Добавляем в журнал 2 статьи
            $authors = factory(\App\Models\Author::class, 2)->make();
            $this->release->articles()->saveMany(factory(Article::class, 2)
                 ->create()
                 ->each(function ($article) use ($authors) {
                    $article->authors()->saveMany($authors);
                 }));
            // Добавляем их в корзину
            foreach ($this->release->articles as $article) {
                $response = $this->postAjax(route('cart.add'), [
                    'id'      => $article->id,
                    'type'    => Cart::PRODUCT_TYPE_ARTICLE,
                    'version' => Cart::VERSION_ELECTRONIC
                ]);
                $response->assertStatus(200)
                         ->assertJson([
                             'success' => true,
                         ]);
            }
        }
    }

    public function testMakeOrder()
    {
        $this->addToCart();
        $response = $this->get(route('order.make'));
        $response->assertStatus(200);
    }

    public function testMakeOrderEmptyCart()
    {
        $response = $this->get(route('order.make'));
        $response->assertStatus(302);
    }

    public function testProcessOrderPhysical()
    {
        Mail::fake();
        $this->addToCart();
        $response = $this->postAjax(route('order.make'), $this->p_data);
        $response->assertStatus(200);
        // При оформлении заказа, должен создаться новый пользователь
        $newUser = User::whereEmail($this->p_data['email'])->first();
        $this->assertNotNull($newUser);
        // Проверяем, что произошла авторизация
        $this->assertAuthenticatedAs($newUser);
        // Получаем заказ через модель юзера
        $order = $newUser->orders()->first();
        $this->assertNotNull($order);
        // Проверяем, что нас переадресовало на страницу завершения заказа
        $response->assertJson([
            'success'  => true,
            'redirect' => route('order.complete', $order->id),
        ]);
        // Проверяем страницу заказа
        $response = $this->get(route('order.complete', $order->id));
        $response->assertStatus(200);
        // Проверяем отмену заказа
        $response = $this->get(route('order.cancel', $order->id));
        $response->assertStatus(302);
        // Проверяем, что заказ отменился
        $this->assertEquals(Order::find($order->id)->status, Order::STATUS_CANCELLED);
    }

    public function testCancelWrongOrder()
    {
        // Пробуем отменить заказ не принадлежащий юзеру
        $this->actingAs($this->user);
        $response = $this->get(route('order.cancel', 13));
        // Должна быть переадресация на страницу с заказами
        $response->assertStatus(302)
                 ->assertRedirect(route('personal.orders'));
    }

    public function testCompleteWrongOrder()
    {
        // Пробуем перейти к завершению заказа, который не принадлежит пользователю
        $this->actingAs($this->user);
        $response = $this->get(route('order.complete', 13));
        // Должна быть переадресация на страницу с заказами
        $response->assertStatus(302)
                 ->assertRedirect(route('personal.orders'));
    }

    public function testProcessOrderLegal()
    {
        $this->addToCart();
        $this->actingAs($this->user);
        $this->l_data['l_email'] = $this->user->email;
        $response = $this->postAjax(route('order.make'), $this->l_data);
        $response->assertStatus(200);
        // Проверяем, что остался авторизованным текущий пользователь
        $this->assertAuthenticatedAs($this->user);
        $order = $this->user->orders()->first();
        // Проверяем, что нас переадресовало на страницу завершения заказа
        $response->assertJson([
            'success'  => true,
            'redirect' => route('order.complete', $order->id),
        ]);
        // Проверяем переход на страницу заказа
        $response = $this->get(route('order.complete', $order->id));
        $response->assertStatus(200);
    }

    public function testCompleteOrderLegal()
    {
        $this->addToCart(3);
        $this->actingAs($this->user);
        $this->l_data['l_email'] = $this->user->email;

        $response = $this->postAjax(route('order.make'), $this->l_data);
        $order = $this->user->orders()->first();
        // Проверяем страницу деталей заказа
        $response = $this->get(route('personal.order', $order->id));
        $response->assertStatus(200);
        // Проверяем страницу оплаты заказа
        $response = $this->get(route('personal.order.payment', $order->id));
        $response->assertStatus(200);
        // Проверяем подтверждение заказа
        $this->assertTrue($order->approve());
        $this->assertEquals(Order::find($order->id)->status, Order::STATUS_COMPLETED);
        // Проверяем невозможность повторного подтверждения заказа
        $this->assertFalse($order->approve());
    }

    public function testCartPage()
    {
        $this->addToCart(2);
        $response = $this->get(route('personal.cart'));
        $response->assertStatus(200)
                 ->assertDontSee('_empty');
    }

    public function testSubscriptionsPage()
    {
        // Повторяем тест, для создания подверждённого заказа
        $this->testCompleteOrderLegal();
        // Для покрытия кода выводим подписки с сортировкой
        $response = $this->get(route('personal.subscriptions', ['sort' => ['type' => 'desc']]));
        $response->assertStatus(200)
                 ->assertDontSee('_empty');
        // Выводим список выпусков, доступных по подписке
        $response = $this->get(route('subscriptions.releases', $this->user->getSubscriptions()->first()->id));
        $response->assertStatus(200)
                 ->assertSee('Выберите выпуск для чтения');
    }

    public function testOrdersPage()
    {
        $this->testCompleteOrderLegal();
        $response = $this->get(route('personal.orders'));
        $response->assertStatus(200)
                 ->assertDontSee('_empty');
    }

    public function testMagazinesPage()
    {
        $this->addToCart(3);
        $this->actingAs($this->user);
        $this->p_data['email']            = $this->user->email;
        $this->p_data['paysystem_physic'] = Paysystem::SBERBANK;
        // Создаём заказ
        $response = $this->postAjax(route('order.make'), $this->p_data);
        $order = $this->user->orders()->first();
        // Подтверждаем его
        $order->approve();
        // Проверяем непустую страницу с журналами
        $response = $this->get(route('personal.magazines'));
        $response->assertStatus(200)
                 ->assertDontSee('_empty');
    }

    public function testForCodeCoverage()
    {
        $this->addToCart(3);
        $this->actingAs($this->user);
        $this->p_data['email']            = $this->user->email;
        $this->p_data['paysystem_physic'] = Paysystem::SBERBANK;

        $response = $this->postAjax(route('order.make'), $this->p_data);
        $order = $this->user->orders()->first();
        $order->approve();

        $this->assertNotNull($order->getDeliveryAddress());
        $this->assertNotNull($order->getFullUserName());
        $this->assertNotNull($order->getDate());
    }
}
