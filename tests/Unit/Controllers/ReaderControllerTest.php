<?php
/**
 * @copyright Copyright (c) 2018-2019 "ИД Панорама"
 * @author
 */
namespace Tests\Unit\Controllers;

use App\Http\Controllers\ReaderController;
use App\Models\Article;
use App\Models\Journal;
use App\Models\Device;
use App\Models\Release;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tests\FactoryTrait;
use Tests\TestCase;

/**
 * Class for reader controller test.
 */
class ReaderControllerTest extends TestCase
{
    use DatabaseTransactions;
    use FactoryTrait;

    /**
     * @var User
     */
    private $user;

    /**
     * @var Release
     */
    private $release;

    /**
     * @var Article
     */
    private $article;

    /**
     * @var Journal
     */
    private $journal;

    /**
     *
     */
    protected function setUp()
    {
        parent::setUp();
        $this->setUserAndDevice();

        $this->journal = $this->factoryJournal();

        $this->release = factory(Release::class)->create([
            'journal_id' => $this->journal->id,
        ]);
        $this->article = factory(Article::class)->create();
    }

    /**
     * @return ReaderController
     */
    public function controller(): ReaderController
    {
        return new ReaderController();
    }

    /**
     * Созд
     */
    public function setUserAndDevice()
    {
        $this->user = $this->user();
    }

    /**
     * Тестовый пользователь
     *
     * @return mixed
     */
    private function user(): User
    {
        return $this->factoryUser();
    }

    /**
     * Проверка обработки сессии на не успешный сброс устройств
     */
    public function testIndexResetWrong()
    {
        $this->actingAs($this->user);

        session()->put('reset-wrong', 1);

        $result = $this->controller()->index($this->request([]));
        $this->assertTrue(session()->has('modal'));
    }

    /**
     * Проверка обработки сессии на успешный сброс устройств
     */
    public function testIndexResetSuccess()
    {
        $this->actingAs($this->user);

        session()->put('reset-success', 1);

        $result = $this->controller()->index($this->request([]));
        $this->assertTrue(!session()->has('reset-success'));
    }

    /**
     * Не авторизованный пользователь
     */
    public function testIndexGuest()
    {
        $result = $this->controller()->index($this->request([])); // Что здесь проверяется?

        $this->assertTrue(session()->has('modal'));
        $this->assertEquals('login-modal', session()->get('modal'));
    }

    /**
     * Читалка. Устройство не найдено
     */
    public function testIndexDeviceNull()
    {
        $this->actingAs($this->user);

        $countBefore = $this->user->devices()->count();
        $result = $this->controller()->index($this->request()); // Что здесь проверяется?

        $countAfter = $this->user->devices()->count();
        $this->assertTrue($countAfter > $countBefore);
    }

    /**
     * Читалка. Устройство найдено по id
     */
    public function testIndexDeviceIsset()
    {
        $this->actingAs($this->user);

        $oDevice = $this->user->createDevice();
        $countBefore = $this->user->devices()->count();

        $_COOKIE['device_id'] = $oDevice->id;

        $result = $this->controller()->index($this->request()); // Что здесь проверяется?

        $countAfter = $this->user->devices()->count();
        $this->assertTrue($countAfter === $countBefore);
    }

    /**
     * Читалка. Устройство не сущенствует по id
     */
    public function testIndexDeviceNotIsset()
    {
        $this->actingAs($this->user);

        $oDevice = $this->user->createDevice();
        $countBefore = $this->user->devices()->count();

        $_COOKIE['device_id'] = Device::orderBy('id', 'desc')->first()->id + 1;

        $result = $this->controller()->index($this->request()); // Что здесь проверяется?

        $countAfter = $this->user->devices()->count();
        $this->assertTrue($countAfter > $countBefore);
    }

    /**
     * Читалка. Максимальное количество устройств
     */
    public function testIndexDeviceMax()
    {
        $this->actingAs($this->user);

        $oDevice = $this->user->createDevice();
        $oDevice->activateDevice();
        $oDevice = $this->user->createDevice();
        $oDevice->activateDevice();

        $countBefore = $this->user->devices()->count();

        $_COOKIE['device_id'] = null;

        $result = $this->controller()->index($this->request()); // Что здесь проверяется?

        $countAfter = $this->user->devices()->count();
        $this->assertTrue($countAfter > $countBefore);
        $this->assertTrue(session()->has('modal'));
        $this->assertEquals('reader-max-devices-modal', session()->get('modal'));
    }

    /**
     * Читалка. Подтвержите устройство
     */
    public function testIndexDeviceActivation()
    {
        $this->actingAs($this->user);

        $oDevice = $this->user->createDevice();
        $countBefore = $this->user->devices()->count();

        $_COOKIE['device_id'] = null;

        $result = $this->controller()->index($this->request()); // Что здесь проверяется?

        $countAfter = $this->user->devices()->count();
        $this->assertTrue($countAfter > $countBefore);
        $this->assertTrue(session()->has('modal'));
        $this->assertEquals('reader-code-modal', session()->get('modal'));
    }

    /**
     * Читалка, есть устройство онлайн
     */
    public function testIndexDeviceOnline()
    {
        $this->actingAs($this->user);
        $oController = (new ReaderController());

        $oDevice = $this->user->createDevice();
        $oDevice->activateDevice();
        $oDevice->setOnline();
        $oDevice = $this->user->createDevice();
        $oDevice->activateDevice();

        $_COOKIE['device_id'] = $oDevice->id;

        $result = $this->controller()->index($this->request()); // Что здесь проверяется?

        $this->assertTrue(session()->has('modal'));
        $this->assertEquals('reader-confirm-online-modal', session()->get('modal'));
    }

    /**
     * Читалка открыт доступ
     */
    public function testIndexSuccess()
    {
        $this->actingAs($this->user);

        $oDevice = $this->user->createDevice();
        $oDevice->activateDevice();

        $request = new Request();
        $request->merge([
            'release_id' => 1,
        ]);
        $_COOKIE['device_id'] = $oDevice->id;

        $result = $this->controller()->index($this->request([
            'release_id' => 1,
        ])); // Что здесь проверяется?

        $oDevice = $this->user->devices()->where('id', $oDevice->id)->first();
        $this->assertTrue($oDevice->isOnline());
    }

    /**
     * Выпуск
     */
    public function testReleaseWrong()
    {
        $this->actingAs($this->user);

        // Тест открытия ридера без доступных выпусков
        $result = $this->controller()->release($this->request());
        $this->assertTrue(empty($result['data']));
    }

    /**
     * Выпуск
     */
    public function testRelease()
    {
        $this->actingAs($this->user);

        // Устанавливаем отношение release - user, что бы 1 выпуск был доступен
        $this->user->releases()->sync(1);
        $result = $this->controller()->release($this->request());
        $this->assertTrue(!empty($result['data']));
        // Повторное открытие
        $result = $this->controller()->release($this->request());
        $this->assertTrue(!empty($result['data']));
    }

    /**
     * Выпуск
     */
    public function testReleaseFail()
    {
        $oController = (new ReaderController());

        $result = $this->controller()->release($this->request());
        $this->assertFalse($result['success']);
    }

    /**
     * Выпуски
     */
    public function testReleases()
    {
        $oController = (new ReaderController());

        $oRelease = $this->factoryRelease([
            'journal_id' => $this->journal->id,
        ]);

        $result = $this->controller()->releases($this->request([
            'release_id' => $oRelease->id,
        ]));
        $this->assertTrue(!empty($result['data']));
    }

    /**
     * Статьи
     */
    public function testArticles()
    {
        $oController = (new ReaderController());

        $result = $this->controller()->articles($this->request());
        $this->assertTrue(!empty($result['data']));
    }

    /**
     * Подтверждение устройства, устройство не найдено
     */
    public function testCodeNullDevice()
    {
        $this->actingAs($this->user);

        $oDevice = $this->user->createDevice();
        $oDevice->sendCodeToUser();

        $_COOKIE['device_id'] = null;

        $result = $this->controller()->code($this->request([
            'code' => $oDevice->activate_code . '00000',
        ]));
        $this->assertFalse($result->getData()->success);
    }

    /**
     * Неверный код подтверждения
     */
    public function testCodeWrongCode()
    {
        $this->actingAs($this->user);

        $oDevice = $this->user->createDevice();
        $oDevice->sendCodeToUser();

        $_COOKIE['device_id'] = $oDevice->id;

        $result = $this->controller()->code($this->request([
            'code' => $oDevice->activate_code . '00000',
        ]));
        $this->assertFalse($result->getData()->success);
    }

    /**
     * Код подтверждения успешный
     */
    public function testCodeSuccess()
    {
        $this->actingAs($this->user);

        $oDevice = $this->user->createDevice();
        $oDevice->sendCodeToUser();

        $_COOKIE['device_id'] = $oDevice->id;

        $result = $this->controller()->code($this->request([
            'code' => $oDevice->activate_code,
        ]));
        $this->assertTrue($result['success']);
    }

    /**
     * Email для кода подтверждения устройства: успешный
     */
    public function testEmailSuccess()
    {
        $this->actingAs($this->user);

        $result = $this->controller()->email($this->request([
            'email' => 'ewfweqfe@mail.ru',
        ]));
        $this->assertTrue($result['success']);
    }
    /**
     * Email для кода подтверждения устройства: успешный
     */
    public function testEmailWrong()
    {
        $this->actingAs($this->user);

        $result = $this->controller()->email($this->request([
            'email' => 'ewfweqfemail',
        ]));
        $this->assertFalse($result->getData()->success);
    }

    /**
     * Проверка онлайн, устройство не найдено
     */
    public function testOnlineNullDevice()
    {
        $this->actingAs($this->user);

        $oDevice = $this->user->createDevice();
        $oDevice->activateDevice();

        $_COOKIE['device_id'] = null;

        $result = $this->controller()->online($this->request());
        $this->assertFalse($result['success']);
    }

    /**
     * Читать с этого устройства
     */
    public function testOnlineSetOnline()
    {
        $this->actingAs($this->user);

        $oDevice = $this->user->createDevice();
        $oDevice->activateDevice();

        $_COOKIE['device_id'] = $oDevice->id;

        $result = $this->controller()->online($this->request([
            'online' => 1,
        ]));
        $oDevice = $this->user->devices()->where('id', $oDevice->id)->first();
        $this->assertTrue($oDevice->isOnline());
    }

    /**
     * Запрос ссылки сброса устройств
     */
    public function testOnlineReset()
    {
        $this->actingAs($this->user);

        $oDevice = $this->user->createDevice();
        $oDevice->activateDevice();

        $_COOKIE['device_id'] = $oDevice->id;

        $result = $this->controller()->online($this->request([
            'reset' => 1,
        ]));
        $this->assertEquals(5, $result['result']);
    }

    /**
     * Есть онлайн устройства
     */
    public function testOnlineHasOnline()
    {
        $this->actingAs($this->user);

        $oDevice = $this->user->createDevice();
        $oDevice->activateDevice();
        $oDevice->setOnline();

        $oDevice = $this->user->createDevice();
        $oDevice->activateDevice();

        $_COOKIE['device_id'] = $oDevice->id;

        $result = $this->controller()->online($this->request());
        $this->assertFalse($result['success']);
    }

    /**
     * Проверка онлайн успешна
     */
    public function testOnlineSuccess()
    {
        $this->actingAs($this->user);
        $oController = (new ReaderController());

        $oDevice = $this->user->createDevice();
        $oDevice->activateDevice();
        $oDevice->setOnline();

        $_COOKIE['device_id'] = $oDevice->id;

        $result = $this->controller()->online($this->request());
        $this->assertTrue($result['success']);
    }

    /**
     * Сброс устройств для неавторизованного пользователя
     */
    public function testResetGuest()
    {
        $result = $this->controller()->reset($this->request(), 'code');

        $this->assertTrue(session()->has('modal'));
        $this->assertEquals('login-modal', session()->get('modal'));
    }

    /**
     * Не успешный сброс устройств, неверный код
     */
    public function testResetCheckError()
    {
        $this->actingAs($this->user);

        $oDevice = $this->user->createDevice();
        $oDevice->activateDevice();

        $result = $this->controller()->reset($this->request(), 'code');

        $this->assertTrue(session()->has('reset-wrong'));
        $oDevice = $this->user->devices()->where('id', $oDevice->id)->first();
        $this->assertEquals(1, $oDevice->active);
    }

    /**
     * Успешный сброс устройств
     */
    public function testResetCheckSuccess()
    {
        $this->actingAs($this->user);

        $oDevice = $this->user->createDevice();
        $oDevice->activateDevice();

        $code = encrypt($this->user->id . ':' . $this->user->email);

        $result = $this->controller()->reset($this->request(), $code);

        $this->assertTrue(session()->has('reset-success'));
        $oDevice = $this->user->devices()->where('id', $oDevice->id)->first();
        $this->assertEquals(0, $oDevice->active);
    }

    /**
     * Тест закладок выбор
     */
    public function testBookmarks()
    {
        $this->actingAs($this->user);

        $result = $this->controller()->bookmarks($this->request());

        $this->assertTrue($result['success']);
    }

    /**
     * Тест закладок создание
     */
    public function testBookmarksCreate()
    {
        $this->actingAs($this->user);

        $result = $this->controller()->bookmarks($this->request([
            'release_id' => $this->release->id,
        ]));
        $this->assertEquals([], $result['data']);

        $result = $this->controller()->bookmarksCreate($this->request([
            'release_id' => $this->release->id,
            'article_id' => $this->article->id,
            'title' => 'Название закладки',
            'scroll' => 0,
            'tag_number' => 1,
        ]));
        $this->assertTrue($result['success']);

        $result = $this->controller()->bookmarks($this->request([
            'release_id' => $this->release->id,
        ]));
        $this->assertContains('id', $result);
        $this->assertContains('owner_type', $result);
        $this->assertContains('release_id', $result);
        $this->assertContains('article_id', $result);
        $this->assertContains('title', $result);
    }

    /**
     * Тест закладок удаление
     */
    public function testBookmarksDestroy()
    {
        $this->actingAs($this->user);

        $result = $this->controller()->bookmarks($this->request([
            'release_id' => $this->release->id,
        ]));
        $this->assertTrue(empty($result['data']));

        $result = $this->controller()->bookmarksCreate($this->request([
            'release_id' => $this->release->id,
            'article_id' => $this->article->id,
            'title' => 'Название закладки',
            'scroll' => 0,
            'tag_number' => 1,
        ]));
        $this->assertTrue($result['success']);

        $result = $this->controller()->bookmarks($this->request([
            'release_id' => $this->release->id,
        ]));
        $this->assertTrue(!empty($result['data']));

        $bookmark = $result['data'][0];

        $result = $this->controller()->bookmarksDestroy($this->request([
            'release_id' => $this->release->id,
        ]), $bookmark['id']);
        $this->assertTrue($result['success']);

        $result = $this->controller()->bookmarks($this->request([
            'release_id' => $this->release->id,
        ]));
        $this->assertEquals([], $result['data']);
    }
}
