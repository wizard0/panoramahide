<?php
/**
 * @copyright Copyright (c) 2018-2019 "ИД Панорама"
 * @author    Илья Картунин (ikartunin@gmail.com)
 */
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Release;
use App\Models\Journal;
use App\Models\Quota;
use App\Models\Partner;
use App\Models\PartnerUser;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Class for partners test.
 */
class PartnersTest extends TestCase
{
    use DatabaseTransactions;

    protected $partner;
    protected $user;

    protected function setUp()
    {
        parent::setUp();
        $user = factory(PartnerUser::class)->create();
        $this->partner = $user->partner()->first();
        $this->user    = $this->partner->users()->first();

        for ($i = 0; $i < 5; $i++) {
            $newQuata = ['active' => true];
            $newQuata['partner_id'] = $this->partner->id;

            $journal = factory(Journal::class)->create();
            $newQuata['journal_id'] = $journal->id;
            $journal->releases()->save(factory(Release::class)->make());


            $newQuata['release_begin'] = '2018-' . mt_rand(1, 6) . '-' . mt_rand(1, 28) . ' 00:00:00';
            $newQuata['release_end'] = '2018-' . mt_rand(7, 12) . '-' . mt_rand(1, 30) . ' 00:00:00';

            $journal = factory(Journal::class)->create();
            $journal->releases()->save(factory(Release::class)->make());
            $newQuata['release_id'] = $journal->releases()->first()->id;

            $newQuata['quota_size'] = mt_rand(1, 99);

            Quota::create($newQuata);
        }
    }

    protected function tearDown()
    {
        unset($this->user);
        unset($this->partner);
    }

    /**
     * Тесты по квотам
     */
    public function testGetQuotasReleases()
    {
        $this->assertNotEmpty($this->partner->quotas, $this->textRed('Квоты не созданы'));
        $quota = $this->partner->quotas()->first();
        $this->assertNotNull($quota, $this->textRed('Не удалось получить квоту партнёра'));
        $this->assertNotEmpty($quota->getReleases(), $this->textRed('Не удалось получить выпуски по квоте'));
    }

    public function testUseQuotasTrue()
    {
        $quota = $this->partner->quotas()->first();

        // Проверяем связь квоты с партнёром
        $this->assertNotNull($quota->partner, $this->textRed('Не работает связь квоты с партнёром'));
        // Пробуем использовать активную квоту
        $this->assertTrue($this->user->useQuota($quota->id), $this->textRed('Не удалось использовать активную квоту'));
        // Пробуем использовать квоту повторно
        $this->assertTrue($this->user->useQuota($quota->id), $this->textRed('Ошибка при повторной попытке использовать квоту'));
    }

    public function testUseQuotasFalse()
    {
        // Пробуем использовать квоту с неверным ID
        $this->assertFalse($this->user->useQuota(''), $this->textRed('Ошибка при попытке использовать квоту с неверным ID'));

        $quota = $this->partner->quotas()->first();
        $quota->setActive(false);

        // Пробуем использовать неактивную квоту
        $this->assertFalse($this->user->useQuota($quota->id), $this->textRed('Ошибка при попытке использовать не активную квоту'));

        $quota->setActive(true);
        // Пробуем использовать квоту, с исчерпанным лимитом
        $quota->used = $quota->quota_size;
        $quota->save();

        $this->assertFalse($this->user->useQuota($quota->id), $this->textRed('Ошибка при активации квоты с исчерпанным лимитом'));
    }

    public function testUseQuotasWithNotActivePartnerAndUser()
    {
        $quota = $this->partner->quotas()->first();

        $this->user->setActive(false);
        // Пробуем использовать квоту через неактивного пользователя
        $this->assertFalse($this->user->useQuota($quota->id), $this->textRed('Ошибка при попытке использовать квоту через неактивного пользователя'));

        $this->user->partner->setActive(false);
        // Пробуем использовать квоту через неактивного партнёра
        $this->assertFalse($this->user->useQuota($quota->id), $this->textRed('Ошибка при попытке использовать квоту через неактивного партнёра'));
    }

    public function testPartnerUserReleases()
    {
        $journal = factory(Journal::class)->create();
        for ($i = 0; $i < 5; $i++) {
            $this->user->releases()->save(factory(Release::class)->create(['journal_id' => $journal->id]));
        }
        $this->assertEquals($this->user->releases()->count(), 5, $this->textRed('Ошибка при добавлении выпусков пользователю'));
    }
}
