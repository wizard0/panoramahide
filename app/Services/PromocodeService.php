<?php

namespace App\Services;

use App\Models\Journal;
use App\Models\JbyPromo;
use App\Models\Promocode;
use App\Models\PromoUser;
use App\Models\Release;
use App\Services\GetSetable\PromocodeGetSetableTrait;
use App\Services\GetSetable\PromoUserGetSetableTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class PromocodeService
{
    use PromocodeGetSetableTrait;
    use PromoUserGetSetableTrait;
    use Messageable;

    /**
     * Текущая дата
     *
     * @var Carbon|null
     */
    private $now = null;

    /**
     * PromocodeService constructor.
     * @param Promocode|null $promocode
     */
    public function __construct(Promocode $promocode = null)
    {
        if (!is_null($promocode)) {
            $this->setPromocode($promocode);
        }
        $this->now = Carbon::now();
    }

    /**
     * @return PromoUser
     */
    public function promoUser(): PromoUser
    {
        $this->promoUser = Auth::user()->promoUser;
        return $this->promoUser;
    }

    /**
     * @param array $data
     * @return Promocode
     */
    public function create(array $data = []): Promocode
    {
        $data = array_merge([
            'active' => 1,
            'limit' => 0,
            'used' => 0,
            'release_begin' => $this->now,
            'release_end' => $this->now->copy()->addYear(),
            'release_limit' => 1,
        ], $data);

        $this->promocode = Promocode::create($data);

        return $this->promocode;
    }

    /**
     * @param integer $id
     * @param array $data
     * @return Promocode
     */
    public function update($id, array $data = []): Promocode
    {
        $this->promocode = Promocode::find($id);
        $this->promocode->update($data);

        return $this->promocode;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool
    {
        Promocode::destroy($id);
        return true;
    }

    /**
     * @param integer $id
     * @return Promocode
     */
    public function findById(int $id): ?Promocode
    {
        $this->promocode = Promocode::where('id', $id)
            ->where('active', 1)
            ->first();

        return $this->promocode;
    }

    /**
     * @param string $code
     * @return Promocode
     */
    public function findByCode(string $code): ?Promocode
    {
        $this->promocode = Promocode::where('promocode', $code)
            ->where('active', 1)
            ->first();

        return $this->promocode;
    }

    /**
     * @param Promocode $promocode
     * @return bool
     */
    public function checkPromocodeBeforeActivate(Promocode $promocode): bool
    {
        if ($this->now > $promocode->release_end) {
            $this->setMessage('Промокод не действителен.');
            return false;
        }
        if ($promocode->limit !== 0 && $promocode->used >= $promocode->limit) {
            $this->setMessage('Промокод невозможно выбрать. Количество ограничено.');
            return false;
        }
        return true;
    }

    /**
     * Активировать промокод
     *
     * @param Promocode $promocode
     * @param PromoUser $promoUser
     * @return bool
     */
    public function activatePromocode(Promocode $promocode, PromoUser $promoUser): bool
    {
        if ($promocode->type === 'custom') {
            JbyPromo::create([
                'promo_user_id' => $promoUser->id,
                'promocode_id' => $promocode->id,
            ]);
            //$promoUser->promocodes()->attach($promocode->id);
        } else {
            $promoUser->promocodes()->attach($promocode->id);
        }
        $promocode->increment('used');
        return true;
    }

    /**
     * Деактивировать промокод
     *
     * @param Promocode $promocode
     * @param PromoUser $promoUser
     * @return bool
     */
    public function deactivatePromocode(Promocode $promocode, PromoUser $promoUser): bool
    {
        $promoUser->promocodes()->detach($promocode->id);
        return true;
    }

    /**
     * @return string
     */
    public function redirectsByType()
    {
        $oPromocode = $this->promocode();
        switch ($oPromocode->type) {
            case 'custom':
                return route('deskbooks.index', [
                    'promocode' => $oPromocode->id
                ]);
            default:
                return route('home.journals');
        }
    }

    /**
     * @return Collection
     */
    public function getReleases(): Collection
    {
        $oPromocode = $this->promocode();
        $oReleases = Release::orderBy('created_at', 'desc');
        switch ($oPromocode->type) {
            case 'common':
                $oReleases = $this->queryReleasesByCommon($oPromocode, $oReleases);
                break;
            case 'on_journal':
                $oReleases = $this->queryReleasesByOnJournal($oPromocode, $oReleases);
                break;
            case 'on_publishing':
                $oReleases = $this->queryReleasesByOnPublishing($oPromocode, $oReleases);
                break;
            case 'on_release':
                $oReleases = $this->queryReleasesByOnRelease($oPromocode, $oReleases);
                break;
            case 'publishing+release':
                $oReleases = $this->queryReleasesByPublishingPlusRelease($oPromocode, $oReleases);
                break;
            case 'custom':
                $oReleases = $this->queryReleasesByCustom($oPromocode, $oReleases);
                break;
        }
        return $oReleases->get();
    }

    /**
     * Общий - промо-выпуски (отмеченные как промо) журналов тех издательств, которые выбрал промо-участник.
     *
     * @param Promocode $oPromocode
     * @param Release|Builder $query
     * @return Release|Builder
     */
    private function queryReleasesByCommon(Promocode $oPromocode, $query)
    {
        $aPublishings = $this->promoUser()->publishings->pluck('id')->toArray();
        //$aPublishings = $oPromocode->publishings->pluck('id')->toArray();

        $query = $query
            ->join('journal_publishing', 'releases.journal_id', '=', 'journal_publishing.journal_id')
            ->whereIn('journal_publishing.publishing_id', $aPublishings)
            ->where('promo', true);

        return $query;
    }

    /**
     * На журнал - промо-выпуски журнала, указанного в промокоде (свойство "Журнал")
     *
     * @param Promocode $oPromocode
     * @param Release|Builder $query
     * @return Release|Builder
     */
    private function queryReleasesByOnJournal(Promocode $oPromocode, $query)
    {
        $query = $query
            ->where('journal_id', $oPromocode->journal_id)
            ->where('promo', true);

        return $query;
    }

    /**
     * На издательство - как и общий, но если заданы "дата начала выпусков" и "дата окончания выпусков", то они используются как ограничение по дате выхода выпусков.
     *
     * @param Promocode $oPromocode
     * @param Release|Builder $query
     * @return Release|Builder
     */
    private function queryReleasesByOnPublishing(Promocode $oPromocode, $query)
    {
        $query = $this->queryReleasesByCommon($oPromocode, $query);
        $query = $this->queryReleasesByActiveDate($oPromocode, $query);

        return $query;
    }

    /**
     * На выпуск - выпуски из свойства "Выпуски" + если заданы свойства "дата начала выпусков", "дата окончания выпусков" и "журнал для выпусков", то все выпуски этого журнала,
     * вышедшие в указанный интервал
     *
     * @param Promocode $oPromocode
     * @param Release|Builder $query
     * @return Release|Builder
     */
    private function queryReleasesByOnRelease(Promocode $oPromocode, $query)
    {
        $query = $query
            ->whereIn('id', $oPromocode->releases->pluck('id')->toArray());

        $query = $this->queryReleasesByActiveDate($oPromocode, $query);

        if ($oPromocode->journal_id) {
            $query = $query->where('releases.journal_id', $oPromocode->journal_id);
        }
        return $query;
    }

    /**
     * На издательство + на выпуски - объединение выпусков вида "На издательство" и "На выпуск"
     *
     * @param Promocode $oPromocode
     * @param Release|Builder $query
     * @return Release|Builder
     */
    private function queryReleasesByPublishingPlusRelease(Promocode $oPromocode, $query)
    {
        $query = $this->queryReleasesByCommon($oPromocode, $query);

        $query = $query
            ->whereIn('id', $oPromocode->releases->pluck('id')->toArray());

        $query = $this->queryReleasesByActiveDate($oPromocode, $query);

        if ($oPromocode->journal_id) {
            $query = $query->where('releases.journal_id', $oPromocode->journal_id);
        }
        return $query;
    }

    /**
     * Выборочный - промо-выпуски журналов из записи в "Выбранные журналы по промокоду" с привязкой к этому промокоду и этому пользователю
     * При активации/использовании промокода у него увеличивается на 1 свойство "использован".
     *
     * @param Promocode $oPromocode
     * @param Release|Builder $query
     * @return Release|Builder
     */
    private function queryReleasesByCustom(Promocode $oPromocode, $query)
    {
        if ($oPromocode->journal_id) {
            $query = $query->where('journal_id', $oPromocode->journal_id);
        }
        return $query;
    }

    /**
     * @param Promocode $oPromocode
     * @param Release|Builder $query
     * @return Release|Builder
     */
    private function queryReleasesByActiveDate(Promocode $oPromocode, $query)
    {
        if (!is_null($oPromocode->release_begin)) {
            $query = $query->where('releases.active_date', '>=', $oPromocode->release_begin);
        }
        if (!is_null($oPromocode->release_end)) {
            $query = $query->where('releases.active_date', '<=', $oPromocode->release_end);
        }
        return $query;
    }


    /**
     * @return Collection
     */
    public function getJournals()
    {
        $oPromocode = $this->promocode();
        $oJournals = Journal::orderBy('created_at', 'desc');
        switch ($oPromocode->type) {
            case 'common':
                $oJournals = $this->queryJournalsByCommon($oPromocode, $oJournals);
                break;
            case 'on_journal':
                $oJournals = $this->queryJournalsByOnJournal($oPromocode, $oJournals);
                break;
            case 'on_publishing':
                $oJournals = $this->queryJournalsByOnPublishing($oPromocode, $oJournals);
                break;
            case 'on_release':
                $oJournals = $this->queryJournalsByOnRelease($oPromocode, $oJournals);
                break;
            case 'publishing+release':
                $oJournals = $this->queryJournalsByPublishingPlusRelease($oPromocode, $oJournals);
                break;
            case 'custom':
                $oJournals = $this->queryJournalsByCustom($oPromocode, $oJournals);
                break;
        }
        return $oJournals;
    }

    /**
     * @param Promocode $oPromocode
     * @param Builder|Journal $query
     * @return Collection
     */
    private function queryJournalsByCommon(Promocode $oPromocode, $query): Collection
    {
        return $query->get();
    }

    /**
     * @param Promocode $oPromocode
     * @param Builder|Journal $query
     * @return \Illuminate\Support\Collection
     */
    private function queryJournalsByOnJournal(Promocode $oPromocode, $query): \Illuminate\Support\Collection
    {
        $oJournal = $oPromocode->journal;

        $oJournals = collect([])->push($oJournal);

        return $oJournals;
    }

    /**
     * @param Promocode $oPromocode
     * @param Builder|Journal $query
     * @return \Illuminate\Support\Collection
     */
    private function queryJournalsByOnPublishing(Promocode $oPromocode, $query): \Illuminate\Support\Collection
    {
        $oPublishings = $oPromocode->publishings;

        $oJournals = collect([]);

        foreach ($oPublishings as $oPublishing) {
            $oJournals = $oJournals->merge($oPublishing->journals);
        }

        return $oJournals;
    }

    /**
     * @param Promocode $oPromocode
     * @param Builder|Journal $query
     * @return \Illuminate\Support\Collection
     */
    private function queryJournalsByOnRelease(Promocode $oPromocode, $query): \Illuminate\Support\Collection
    {
        $oReleases = $oPromocode->releases;

        $oJournals = collect([]);

        foreach ($oReleases as $oRelease) {
            $oJournals = $oJournals->merge(collect([])->push($oRelease->journal));
        }

        return $oJournals;
    }

    /**
     * @param Promocode $oPromocode
     * @param Builder|Journal $query
     * @return \Illuminate\Support\Collection
     */
    private function queryJournalsByPublishingPlusRelease(Promocode $oPromocode, $query): \Illuminate\Support\Collection
    {
        return $query->get();
    }

    /**
     * @param Promocode $oPromocode
     * @param Builder|Journal $query
     * @return \Illuminate\Support\Collection
     */
    private function queryJournalsByCustom(Promocode $oPromocode, $query): \Illuminate\Support\Collection
    {
        $oJournals = new PromocodeCustomService($oPromocode, $this->promoUser);

        return $oJournals->getPromoUserJournals();
    }
}
