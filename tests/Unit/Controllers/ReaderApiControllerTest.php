<?php
namespace Tests\Unit\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ReaderApiController;
use App\Http\Controllers\ReaderController;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Release;
use App\Journal;
use App\Models\Quota;
use App\Models\Partner;
use App\Models\PartnerUser;

class ReaderApiControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $partner;
    protected $user;
    protected $quota;
    protected $release_id;

    protected function setUp()
    {
        parent::setUp();

        $_SERVER['REQUEST_URI'] = '';

        $this->user = factory(PartnerUser::class)->create();
        $this->partner = $this->user->partner()->first();

        $newQuata = ['active' => true];
        $newQuata['partner_id'] = $this->partner->id;

        $journal = factory(Journal::class)->create();
        $newQuata['journal_id'] = $journal->id;
        $journal->releases()->save(factory(Release::class)->make());

        $journal = factory(Journal::class)->create();
        $journal->releases()->save(factory(Release::class)->make());
        $newQuata['release_id'] = $journal->releases()->first()->id;
        $newQuata['quota_size'] = 100;

        $this->release_id = $newQuata['release_id'];

        $this->quota = Quota::create($newQuata);
    }

    protected function tearDown()
    {
        unset($this->user);
        unset($this->partner);
    }

    public function testGetReleasesList()
    {
        // Получаем ссылку на страницу с релизами по квоте
        $url = route('api.releases', [$this->partner->secret_key, md5($this->user->user_id), $this->quota->id], false);
        $response = $this->get($url);
        // Проверяем статус
        $response->assertStatus(200);
        // Проверяем, что вывелась нужная страница
        $response->assertSee('Выберите выпуск для чтения');
    }

    public function testGetRelease()
    {
        // Получаем ссылку на релиз
        $url = route('api.release', [$this->partner->secret_key, $this->user->user_id, $this->quota->id, $this->release_id], false);
        $response = $this->get($url);
        // Проверяем, что происходит редирект на читалку
        $response->assertStatus(302);
        // Проверяем ссылку для перехода к читалке
        $readerUrl = route('reader.index', ['release_id' => $this->release_id]);
        $response->assertRedirect($readerUrl);
        // Проверяем куку пользователя партнёра
        $response->assertCookie('PartnerUser', $this->partner->id.'|@|@|'.$this->user->user_id);
    }

    public function testReaderByPartnerUser()
    {
        $readerUrl = route('reader.index', ['release_id' => $this->release_id]);
        // Переходим на читалку с неверной кукой
        $response = $this->call('GET', $readerUrl, [], ['PartnerUser' => \Crypt::encrypt($this->partner->id.'||'.$this->user->user_id)]);
        $response->assertStatus(200)
                 ->assertSee('partner:        0,');
        // Переходим на читалку с кукой юзера
        $response = $this->call('GET', $readerUrl, [], ['PartnerUser' => \Crypt::encrypt($this->partner->id.'|@|@|'.$this->user->user_id)]);
        $response->assertStatus(200)
                 ->assertSee('partner:        1,');
        // Переходим на читалку с кукой юзера но без email
        $this->user->email = null;
        $this->user->save();
        $response = $this->call('GET', $readerUrl, [], ['PartnerUser' => \Crypt::encrypt($this->partner->id.'|@|@|'.$this->user->user_id)]);
        $response->assertStatus(200)
                 ->assertSee('partner:        1,');
        /*
        $url = route('reader.release', [], false);
        $response = $this->call('POST', $url, ['id' => $this->release_id], ['PartnerUser' => \Crypt::encrypt($this->partner->id.'|@|@|'.$this->user->user_id)]);
        $response->assertStatus(200)
                 ->assertJson([
                    'success' => false,
                ]);
        */
    }

    public function testManyDevices()
    {
        $readerUrl = route('reader.index', ['release_id' => $this->release_id]);
        $device = $this->user->createDevice();
        $device->activateDevice();
        $device = $this->user->createDevice();
        $device->activateDevice();
        $device = $this->user->createDevice();
        $device->activateDevice(false);
        $response = $this->call('GET', $readerUrl, [], ['PartnerUser' => \Crypt::encrypt($this->partner->id.'|@|@|'.$this->user->user_id)]);
        $response->assertStatus(200)
                 ->assertSee('reader-max-pu-devices-modal');
    }
}
