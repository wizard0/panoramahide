<?php

namespace App\Services;


use App\Models\Promocode;
use App\Models\PromoUser;
use App\Release;
use Carbon\Carbon;

class PromocodeService
{

    /**
     * Promocode
     * @var null
     */
    private $promocode = null;

    /**
     * Текущая дата
     *
     * @var Carbon|null
     */
    private $now = null;

    /**
     * Сообщение с текстом ошибки
     *
     * @var null
     */
    private $message = null;

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
     * @return Promocode
     */
    public function promocode(): Promocode
    {
        return $this->promocode;
    }

    /**
     * @param array $data
     * @return null
     */
    public function create(array $data = [])
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
     * @param $id
     * @param array $data
     * @return null
     */
    public function update($id, array $data = [])
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
     * @param $id
     * @return Promocode
     */
    public function findById(int $id): Promocode
    {
        $this->promocode = Promocode::where('id', $id)
            ->where('active', 1)
            ->first();

        return $this->promocode;
    }

    /**
     * @param $code
     * @return Promocode
     */
    public function findByCode(string $code): Promocode
    {
        $this->promocode = Promocode::where('promocode', $code)
            ->where('active', 1)
            ->first();

        return $this->promocode;
    }

    /**
     * @param Promocode $promocode
     * @return PromocodeService
     */
    public function setPromocode(Promocode $promocode): PromocodeService
    {
        $this->promocode = $promocode;

        return $this;
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
        try {
            $promoUser->promocodes()->attach($promocode->id);
            $promocode->increment('used');
            return true;
        } catch (\Exception $e) {
            $this->setMessage('' . $e->getMessage());
            return false;
        }
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
        try {
            $promoUser->promocodes()->detach($promocode->id);
            return true;
        } catch (\Exception $e) {
            $this->setMessage('' . $e->getMessage());
            return false;
        }
    }

    /**
     * @return Release
     */
    public function getReleases(): Release
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
            default:
                break;
        }
        return $oReleases->get();
    }

    /**
     * @param Promocode $oPromocode
     * @param Release $oReleases
     * @return Release
     */
    private function queryReleasesByCommon(Promocode $oPromocode, Release $oReleases): Release
    {
        $oReleases = $oReleases
            ->join('journal_publishing', 'releases.journal_id', '=', 'journal_publishing.journal_id')
            ->whereIn('publishing_id', $oPromocode->publishings->pluck('id')->toArray())
            ->where('promo', true);

        return $oReleases;
    }

    /**
     * @param Promocode $oPromocode
     * @param Release $oReleases
     * @return Release
     */
    private function queryReleasesByOnJournal(Promocode $oPromocode, Release $oReleases): Release
    {
        $oReleases = $oReleases
            ->where('journal_id', $oPromocode->journal_id)
            ->where('promo', true);

        return $oReleases;
    }

    /**
     * @param Promocode $oPromocode
     * @param Release $oReleases
     * @return Release
     */
    private function queryReleasesByOnPublishing(Promocode $oPromocode, Release $oReleases): Release
    {
        $oReleases = $oReleases
            ->join('journal_publishing', 'releases.journal_id', '=', 'journal_publishing.journal_id')
            ->whereIn('publishing_id', $oPromocode->publishings->pluck('id')->toArray());

        $oReleases = $this->queryReleasesByActiveDate($oPromocode, $oReleases);

        return $oReleases;
    }

    /**
     * @param Promocode $oPromocode
     * @param Release $oReleases
     * @return Release
     */
    private function queryReleasesByOnRelease(Promocode $oPromocode, Release $oReleases): Release
    {
        $oReleases = $oReleases
            ->whereIn('id', $oPromocode->releases->pluck('id')->toArray());

        $oReleases = $this->queryReleasesByActiveDate($oPromocode, $oReleases);

        if ($oPromocode->journal_id) {
            $oReleases = $oReleases->where('journal_id', $oPromocode->journal_id);
        }
        return $oReleases;
    }

    /**
     * @param Promocode $oPromocode
     * @param Release $oReleases
     * @return Release
     */
    private function queryReleasesByPublishingPlusRelease(Promocode $oPromocode, Release $oReleases): Release
    {
        $oReleases = $oReleases
            ->join('journal_publishing', 'releases.journal_id', '=', 'journal_publishing.journal_id')
            ->whereIn('publishing_id', $oPromocode->publishings->pluck('id')->toArray())
            ->whereIn('id', $oPromocode->releases->pluck('id')->toArray());

        $oReleases = $this->queryReleasesByActiveDate($oPromocode, $oReleases);

        if ($oPromocode->journal_id) {
            $oReleases = $oReleases->where('journal_id', $oPromocode->journal_id);
        }
        return $oReleases;
    }

    /**
     * @param Promocode $oPromocode
     * @param Release $oReleases
     * @return Release
     */
    private function queryReleasesByActiveDate(Promocode $oPromocode, Release $oReleases): Release
    {
        if (!is_null($oPromocode->release_begin)) {
            $oReleases = $oReleases->where('releases.active_date', '>=', $oPromocode->release_begin);
        }
        if (!is_null($oPromocode->release_end)) {
            $oReleases = $oReleases->where('releases.active_date', '<=', $oPromocode->release_end);
        }
        return $oReleases;
    }

    /**
     * @param $message
     */
    private function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }


    public function getRelease($group = null)
    {
        $oPromocode = $this->promocode;
        $Releases = \App\Release::orderBy('id');
        switch ($oPromocode->type) {
            case 'common':
                $Releases->join('journal_publishing', 'releases.journal_id', '=', 'journal_publishing.journal_id')
                    ->whereIn('publishing_id', $oPromocode->publishings->pluck('id')->toArray())
                    ->where('promo', true);
                break;
            case 'on_journal':
                $Releases->where('journal_id', $oPromocode->journal_id)
                    ->where('promo', true);
                break;
            case 'on_publishing':
                $Releases->join('journal_publishing', 'releases.journal_id', '=', 'journal_publishing.journal_id')
                    ->whereIn('publishing_id', $oPromocode->publishings->pluck('id')->toArray());
                if ($oPromocode->release_begin)
                    $Releases->where('releases.active_date', '>=', $oPromocode->release_begin);
                if ($oPromocode->release_end)
                    $Releases->where('releases.active_date', '<=', $oPromocode->release_end);
                break;
            case 'on_release':
                $Releases->whereIn('id', $oPromocode->releases->pluck('id')->toArray());
                if ($oPromocode->release_begin)
                    $Releases->where('releases.active_date', '>=', $oPromocode->release_begin);
                if ($oPromocode->release_end)
                    $Releases->where('releases.active_date', '<=', $oPromocode->release_end);
                if ($oPromocode->journal_id)
                    $Releases->where('journal_id', $oPromocode->journal_id);
                break;
            case 'publishing+release':
                $Releases->join('journal_publishing', 'releases.journal_id', '=', 'journal_publishing.journal_id')
                    ->whereIn('publishing_id', $oPromocode->publishings->pluck('id')->toArray())
                    ->whereIn('id', $oPromocode->releases->pluck('id')->toArray());
                if ($oPromocode->release_begin)
                    $Releases->where('releases.active_date', '>=', $oPromocode->release_begin);
                if ($oPromocode->release_end)
                    $Releases->where('releases.active_date', '<=', $oPromocode->release_end);
                if ($oPromocode->journal_id)
                    $Releases->where('journal_id', $oPromocode->journal_id);
                break;
            case 'custom':
                dd($oPromocode->groups());
                break;
        }
        return $Releases->get();
    }
}
