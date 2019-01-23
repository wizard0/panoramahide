<?php

namespace App\Services;


use App\Models\Promocode;
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

    public function update($id, array $data = [])
    {
        $this->promocode = Promocode::find($id);
        $this->promocode->update($data);

        return $this->promocode;
    }

    public function destroy(int $id): bool
    {
        Promocode::destroy($id);
        return true;
    }

    public function findById($id)
    {
        $this->promocode = Promocode::where('id', $id)
            ->where('active', 1)
            ->first();

        return $this->promocode;
    }

    public function findByCode($code)
    {
        $this->promocode = Promocode::where('code', $code)
            ->where('active', 1)
            ->first();

        return $this->promocode;
    }

    public function setPromocode(Promocode $promocode)
    {
        $this->promocode = $promocode;

        return $this;
    }

    public function checkPromocodeBeforeActivate() : bool
    {
        if ($this->now > $this->promocode->release_end) {
            $this->setMessage('Промокод не действителен.');
            return false;
        }
        if ($this->promocode->used === $this->promocode->limit) {
            $this->setMessage('Промокод невозможно выбрать. Количество ограничено.');
            return false;
        }
        return true;
    }


    /**
     * @param $message
     */
    private function setMessage(string $message) : void
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getMessage() : string
    {
        return $this->message;
    }

    public function getReleases($group = null)
    {
        $oPromocode = $this->promocode;
        $Releases = \App\Release::orderBy('id');
        switch($oPromocode->type) {
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
