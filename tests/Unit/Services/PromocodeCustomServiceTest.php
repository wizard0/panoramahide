<?php

namespace Tests\Unit\Services;

use App\Journal;
use App\Models\Promocode;
use App\Models\PromoUser;
use App\Services\PromocodeCustomService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PromocodeCustomServiceTest extends TestCase
{
    /**
     * Пример использования
     */
    public function example()
    {
        $service = new PromocodeCustomService($this->promocode(), $this->promoUser());
        $oJournal = $this->journal();

        if (!$service->attachJournal($oJournal)) {
            // не удалось добавить журнал к промо-участнику $service->getMessage()
        }

        if (!$service->detachJournal($oJournal)) {
            // не удалось открепить журнал от промо-участника $service->getMessage()
        }

        // все журналы
        $service->getPromoUserJournals();
    }

    /**
     * Тестовый пользователь
     *
     * @return mixed
     */
    private function promoUser(): PromoUser
    {
        return PromoUser::find(1);
    }

    /**
     * Тестовый промокод
     *
     * @return mixed
     */
    private function promocode(): Promocode
    {
        return Promocode::find(1);
    }

    /**
     * Журнал, который в связи с промокодом
     *
     * @return Journal
     */
    private function journal(): Journal
    {
        return Journal::find(1);
    }

    /**
     * Журнал, который не в связи с промокодом
     *
     * @return Journal
     */
    private function journalNotIssetInPromocodes(): Journal
    {
        $oJournals = Journal::all();
        $oJournals = $oJournals->reject(function ($item) {
            return count($item->promocodes) !== 0;
        });
        return $oJournals->first();
    }

    /**
     * Сервис
     *
     * @return PromocodeCustomService
     */
    private function service(): PromocodeCustomService
    {
        return new PromocodeCustomService($this->promocode(), $this->promoUser());
    }

    /**
     * Тестирование привязки журнала по промокоду к промо-участнику
     */
    public function testAttachJournal()
    {
        $oJournal = $this->journalNotIssetInPromocodes();
        $oService = $this->service();

        DB::transaction(function () use ($oJournal, $oService) {

            $oJournal = $this->journal();

            $countBefore = $oService->getPromoUserJournals()->count();

            $result = $oService->attachJournal($oJournal);
            $this->assertTrue($result);

            $countAfter = $this->service()->getPromoUserJournals()->count();

            $this->assertTrue($countAfter > $countBefore);

            DB::rollBack();
        });
    }

    /**
     * Тестирование отвязки журнала по промокоду к промо-участнику
     */
    public function testDetachJournal()
    {
        $oJournal = $this->journalNotIssetInPromocodes();
        $oService = $this->service();

        DB::transaction(function () use ($oJournal, $oService) {

            $oJournal = $this->journal();

            $countBefore = $oService->getPromoUserJournals()->count();

            $result = $oService->attachJournal($oJournal);
            $this->assertTrue($result);

            $countAfter = $this->service()->getPromoUserJournals()->count();

            $this->assertTrue($countAfter > $countBefore);


            $result = $this->service()->detachJournal($oJournal);
            $this->assertTrue($result);

            $countAfterDetach = $this->service()->getPromoUserJournals()->count();

            $this->assertTrue($countAfterDetach < $countAfter && $countAfterDetach === $countBefore);

            DB::rollBack();
        });


    }

    /**
     * Тестирование выборки журналов промо-участника
     */
    public function testGetPromoUserJournals()
    {
        $oJournal = $this->journalNotIssetInPromocodes();
        $oService = $this->service();

        DB::transaction(function () use ($oJournal, $oService) {

            $oJournal = $this->journal();

            $count = $oService->getPromoUserJournals()->count();

            $result = $oService->attachJournal($oJournal);
            $this->assertTrue($result);

            $count++;

            $this->assertTrue($this->service()->getPromoUserJournals()->count() === $count);

            $this->assertTrue($this->service()->getPromoUserJournals() instanceof Collection);

            $this->assertTrue($this->service()->getPromoUserJournals()->first() instanceof Journal);

            DB::rollBack();
        });
    }

    /**
     * Текущий журнал есть в связи с текущим промокодом
     */
    public function testIssetGetJbyPromo()
    {
        $oJournal = $this->journal();

        $this->assertTrue(in_array($this->promocode()->id, $oJournal->promocodes()->pluck('id')->toArray()));
    }

    /**
     * Проверка безсвязного журнала если нет в связи с текущим промокодом
     */
    public function testNotIssetGetJbyPromo()
    {
        $oJournal = $this->journalNotIssetInPromocodes();

        $this->assertTrue(!is_null($oJournal));

        $this->assertTrue(!in_array($this->promocode()->id, $oJournal->promocodes()->pluck('id')->toArray()));

    }
}
