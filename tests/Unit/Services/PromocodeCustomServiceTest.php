<?php

namespace Tests\Unit\Services;

use App\Journal;
use App\Models\Promocode;
use App\Models\PromoUser;
use App\Services\PromocodeCustomService;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Tests\FactoryTrait;
use Tests\TestCase;

/**
 * Class for promocode custom service test.
 */
class PromocodeCustomServiceTest extends TestCase
{
    use FactoryTrait;
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
     * @var PromoUser
     */
    private $promocode;

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
     * @return PromoUser
     */
    private function promoUser(): PromoUser
    {
        return PromoUser::find($this->promoUser->id);
    }

    /**
     * @return Promocode
     */
    private function promocode(): Promocode
    {
        if (is_null($this->promocode)) {
            $this->promocode = $this->factoryPromocode([
                'type' => Promocode::TYPE_CUSTOM,
                'release_end' => now()->addDay(),
                'used' => 0,
                'limit' => 10,
            ]);
        } else {
            $this->promocode->find($this->promocode->id);
        }
        return $this->promocode;
    }

    /**
     * @param Promocode|null $promocode
     * @return PromocodeCustomService
     */
    private function service(Promocode $promocode = null): PromocodeCustomService
    {
        if (is_null($promocode)) {
            $promocode = $this->promocode();
        }
        return new PromocodeCustomService($promocode, $this->promoUser());
    }

    /**
     * Пример использования
     */
    public function example()
    {
        $oJournal = $this->factoryJournal();

        if (!$this->service()->attachJournal($oJournal)) {
            // не удалось добавить журнал к промо-участнику $service->getMessage()
        }

        if (!$this->service()->detachJournal($oJournal)) {
            // не удалось открепить журнал от промо-участника $service->getMessage()
        }

        // все журналы
        $this->service()->getPromoUserJournals();
    }

    /**
     * Тестирование привязки журнала по промокоду к промо-участнику
     */
    public function testAttachJournal()
    {
        $oJournal = $this->factoryJournal();

        $countBefore = $this->service()->getPromoUserJournals()->count();

        $result = $this->service()->attachJournal($oJournal);
        $this->assertTrue($result);

        $countAfter = $this->service()->getPromoUserJournals()->count();
        $this->assertTrue($countAfter > $countBefore);
    }

    /**
     * Тестирование отвязки журнала по промокоду к промо-участнику
     */
    public function testDetachJournal()
    {
        $oJournal = $this->factoryJournal();
        $oPromocode = $this->promocode();

        $oJournal->promocodes()->attach($oPromocode->id);

        $countBefore = $this->service($oPromocode)->getPromoUserJournals()->count();

        $result = $this->service($oPromocode)->attachJournal($oJournal);
        $this->assertTrue($result);

        $countAfter = $this->service($oPromocode)->getPromoUserJournals()->count();
        $this->assertTrue($countAfter > $countBefore);

        $result = $this->service($oPromocode)->detachJournal($oJournal);
        $this->assertTrue($result);

        $countAfterDetach = $this->service($oPromocode)->getPromoUserJournals()->count();
        $this->assertTrue($countAfterDetach < $countAfter && $countAfterDetach === $countBefore);
    }

    /**
     * Тестирование отвязки журнала по промокоду к промо-участнику
     */
    public function testDetachJournalNotExists()
    {
        $oJournal = $this->factoryJournal();
        $oPromocode = $this->promocode();

        $result = $this->service($oPromocode)->detachJournal($oJournal);

        $this->assertFalse($result);
    }

    public function testSyncJournals()
    {
        $oJournal = $this->factoryJournal();

        $oJournals = Journal::where('id', $oJournal->id)->get();

        $result = $this->service()->syncJournal($oJournals);

        $this->assertTrue($result);
    }

    /**
     * Тестирование выборки журналов промо-участника
     */
    public function testGetPromoUserJournals()
    {
        $oJournal = $this->factoryJournal();

        $count = $this->service()->getPromoUserJournals()->count();

        $result = $this->service()->attachJournal($oJournal);
        $this->assertTrue($result);
        $count++;

        $this->assertTrue($this->service()->getPromoUserJournals()->count() === $count);
        $this->assertTrue($this->service()->getPromoUserJournals() instanceof Collection);
        $this->assertTrue($this->service()->getPromoUserJournals()->first() instanceof Journal);
    }

    /**
     * Текущий журнал есть в связи с текущим промокодом
     */
    public function testIssetGetJbyPromo()
    {
        $oJournal = $this->factoryJournal();

        $oJournal->promocodes()->attach($this->promocode()->id);

        $this->assertTrue(in_array($this->promocode()->id, $oJournal->promocodes()->pluck('id')->toArray()));
    }

    /**
     * Проверка безсвязного журнала если нет в связи с текущим промокодом
     */
    public function testNotIssetGetJbyPromo()
    {
        $oJournal = $this->factoryJournal();

        $this->assertTrue(!in_array($this->promocode()->id, $oJournal->promocodes()->pluck('id')->toArray()));
    }
}
