<?php

namespace App\Services;

use App\Models\JbyPromo;
use App\Journal;
use App\Models\Promocode;
use App\Models\PromoUser;
use App\Services\GetSetable\PromocodeGetSetableTrait;
use App\Services\GetSetable\PromoUserGetSetableTrait;
use Illuminate\Support\Collection;

class PromocodeCustomService
{
    use Messageable;
    use PromocodeGetSetableTrait;
    use PromoUserGetSetableTrait;

    /**
     * @var null
     */
    private $journals = null;

    /**
     * PromocodeCustomService constructor.
     * @param Promocode $promocode
     * @param PromoUser $promoUser
     */
    public function __construct(?Promocode $promocode = null, ?PromoUser $promoUser = null)
    {
        $this->promocode = $promocode;
        $this->promoUser = $promoUser;
    }

    /**
     * @return Collection
     */
    public function getPromoUserJournals(): Collection
    {
        $oJbyPromo = $this->promoUser->jByPromo->load('journals');

        $ojByPromoJournals = collect([]);

        if (count($oJbyPromo) !== 0) {
            foreach ($oJbyPromo as $oPromo) {
                $ojByPromoJournals = $ojByPromoJournals->merge($oPromo->journals);
            }
        }
        return $ojByPromoJournals;
    }

    /**
     * @param Journal $oJournal
     * @return bool
     */
    public function attachJournal(Journal $oJournal): bool
    {
        if (!in_array($this->promocode()->id, $oJournal->promocodes()->pluck('id')->toArray())) {
            $this->setMessage('Журнал не привязан к используемому промокоду.');

            $this->promocode()->journals()->sync($oJournal->id);
            //return false;
        }
        $oJbyPromo = $this->getJbyPromo();

        $oJbyPromo->journals()->sync($oJournal->id);

        return true;
    }

    /**
     * @param Collection $oJournals
     * @return bool
     */
    public function syncJournal(Collection $oJournals): bool
    {
        $aId = $oJournals->pluck('id')->toArray();
        foreach ($oJournals as $oJournal) {
            if (!in_array($this->promocode()->id, $oJournal->promocodes()->pluck('id')->toArray())) {
                $this->setMessage('Журнал не привязан к используемому промокоду.');
                //$this->promocode()->journals()->attach($oJournal->id);
                //return false;
            }
        }
        $oJbyPromo = $this->getJbyPromo();
        $this->promocode()->journals()->sync($aId);
        $oJbyPromo->journals()->sync($aId);
        return true;
    }

    /**
     * @param Journal $oJournal
     * @return bool
     */
    public function detachJournal(Journal $oJournal): bool
    {
        if (!in_array($this->promocode()->id, $oJournal->promocodes()->pluck('id')->toArray())) {
            $this->setMessage('Журнал не привязан к используемому промокоду.');
            return false;
        }
        $oJbyPromo = $this->getJbyPromo();

        $oJbyPromo->journals()->detach($oJournal->id);

        return true;
    }

    /**
     * @return JbyPromo
     */
    private function getJbyPromo(): JbyPromo
    {
        $oJbyPromo = JbyPromo::where('promo_user_id', $this->promoUser()->id)
            ->where('promocode_id', $this->promocode()->id)
            ->first();

        if (is_null($oJbyPromo)) {
            $oJbyPromo = JbyPromo::create([
                'promo_user_id' => $this->promoUser()->id,
                'promocode_id' => $this->promocode()->id,
            ]);
        }
        return $oJbyPromo;
    }
}
