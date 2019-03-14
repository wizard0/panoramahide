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
use Tests\FactoryTrait;
use App\Cart;
use App\Models\Subscription;
use App\Models\Journal;
use App\Models\Release;
use App\Models\Article;
use Session;

class ProductCartTest extends TestCase
{
    use DatabaseTransactions;
    use FactoryTrait;

    protected $user;
    protected $journal;
    protected $release;

    protected function setUp()
    {
        parent::setUp();
        $this->user = $this->factoryUser();
        $this->journal = factory(Journal::class)->create();
        $this->release = factory(Release::class)->create(['journal_id' => $this->journal->id]);
    }

    public function testWrongCartRequest()
    {
        $response = $this->post(route('cart.add'));
        $response->assertStatus(200)
                 ->assertJson([
                    'success' => false,
                 ]);
        $response = $this->post(route('cart.del'));
        $response->assertStatus(200)
                 ->assertJson([
                    'success' => false,
                 ]);

        $response = $this->postAjax(route('cart.add'), [
            'id'      => '$this->release->id',
            'type'    => 'Cart::PRODUCT_TYPE_RELEASE',
            'version' => 'Cart::VERSION_PRINTED'
        ]);
        $response->assertStatus(500);

        $response = $this->postAjax(route('cart.add'), [
            'id'             => 0,
            'type'           => Cart::PRODUCT_TYPE_SUBSCRIPTION,
            'version'        => Cart::VERSION_PRINTED,
            'additionalData' => [
                'type'         => Cart::PRODUCT_TYPE_SUBSCRIPTION,
                'start_month'  => '201901',
                'term'         => 12,
                'single_price' => 0,
                'journal_id'   => $this->journal->id,
            ],
        ]);
    }

    public function testCartAddRelease()
    {
        // Добавляем журнал в корзину
        $response = $this->postAjax(route('cart.add'), [
            'id'      => $this->release->id,
            'type'    => Cart::PRODUCT_TYPE_RELEASE,
            'version' => Cart::VERSION_PRINTED
        ]);
        $response->assertStatus(200)
                 ->assertJson([
                    'success' => true,
                 ]);
        // Добавляем в корзину ещё один экземпляр того же журнала
        $response = $this->postAjax(route('cart.add'), [
            'id'      => $this->release->id,
            'type'    => Cart::PRODUCT_TYPE_RELEASE,
            'version' => Cart::VERSION_PRINTED
        ]);
        $response->assertStatus(200)
                 ->assertJson([
                    'success' => true,
                 ]);
    }

    public function testCartDel()
    {
        // Добавляем журнал в корзину
        $response = $this->postAjax(route('cart.add'), [
            'id'      => $this->release->id,
            'type'    => Cart::PRODUCT_TYPE_RELEASE,
            'version' => Cart::VERSION_ELECTRONIC
        ]);
        $response->assertStatus(200)
                 ->assertJson([
                    'success' => true,
                 ]);
        // Удаляем журнал из корзины
        $response = $this->postAjax(route('cart.del'), [
            'id'      => Cart::PRODUCT_TYPE_RELEASE . $this->release->id,
        ]);
        $response->assertStatus(200)
                 ->assertJson([
                    'success' => true,
                 ]);
    }

    public function testCartAddArticle()
    {
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

    public function testCartAddSubscription()
    {
        $subscription = factory(Subscription::class)->create([
                            'journal_id' => $this->journal->id,
                            'locale' => \App::getLocale(),
                            'half_year' => 'second',
                            'type' => Subscription::TYPE_PRINTED
                        ]);
        // Добавляем в корзину подписку на журнал
        $response = $this->postAjax(route('cart.add'), [
            'id'             => $subscription->id,
            'type'           => Cart::PRODUCT_TYPE_SUBSCRIPTION,
            'version'        => Cart::VERSION_PRINTED,
            'additionalData' => [
                'type'         => Cart::PRODUCT_TYPE_SUBSCRIPTION,
                'start_month'  => '201901',
                'term'         => 12,
                'single_price' => 100,
                'journal_id'   => $this->journal->id,
            ],
        ]);
        $response->assertStatus(200)
                 ->assertJson([
                    'success' => true,
                 ]);
    }

    public function testCartQtyChange()
    {
        // Добавляем журнал в корзину
        $response = $this->postAjax(route('cart.add'), [
            'id'      => $this->release->id,
            'type'    => Cart::PRODUCT_TYPE_RELEASE,
            'version' => Cart::VERSION_PRINTED
        ]);
        $prdId = Cart::PRODUCT_TYPE_RELEASE . $this->release->id;
        // Имитируем ошибку
        $response = $this->post(route('cart.qty'), [
            'id'  => $prdId,
            'qty' => 2,
        ]);
        $response->assertStatus(200)
                 ->assertJson([
                    'success' => false,
                 ]);
        // меняем количество журналов на 2
        $response = $this->postAjax(route('cart.qty'), [
            'id'  => $prdId,
            'qty' => 2,
        ]);
        $response->assertStatus(200)
                 ->assertJson([
                    'success' => true,
                 ]);
        $cart = new Cart(Session::get('cart'));
        $this->assertEquals($cart->items[$prdId]->qty, 2);
    }
}
