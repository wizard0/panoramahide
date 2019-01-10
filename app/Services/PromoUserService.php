<?php

namespace App\Services;


use App\Models\PromoUser;
use App\Promocode;
use Carbon\Carbon;

class PromoUserService
{
    /**
     * Промо-юзер
     *
     * @var PromoUser|null
     */
    private $promoUser = null;

    /**
     * Промомкоды промо-юзера
     *
     * @var mixed|null
     */
    private $promoUserPromocodes = null;

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
     * PromoUserService constructor.
     * @param PromoUser $promoUser
     */
    public function __construct(PromoUser $promoUser)
    {
        $this->promoUser = $promoUser;
        $this->promoUserPromocodes = $promoUser->promocodes;
        $this->now = Carbon::now();
    }

    /**
     * Активировать промокод
     *
     * @param Promocode $promocode
     * @return bool
     */
    public function activatePromocode(Promocode $promocode) : bool
    {
        if ($this->checkPromocodeBeforeActivate($promocode)) {
            $this->promoUser->promocodes()->attach($promocode->id);
            $promocode->increment('used');
            return true;
        }
        return false;
    }

    /**
     * Деактивировать промокод
     *
     * @param Promocode $promocode
     * @return bool
     */
    public function deactivatePromocode(Promocode $promocode) : bool
    {
        $exists = $this->promoUserPromocodes->where('id', $promocode->id)->first();
        if (is_null($exists)) {
            $this->setMessage('Промокод не был применен.');
            return false;
        }
        return true;
    }

    /**
     * Проверить промокод перед активацией
     *
     * @param Promocode $promocode
     * @return bool
     */
    private function checkPromocodeBeforeActivate(Promocode $promocode) : bool
    {
        if ($this->now > $promocode->release_end) {
            $this->setMessage('Промокод не действителен.');
            return false;
        }
        if ($promocode->used === $promocode->limit) {
            $this->setMessage('Промокод невозможно выбрать. Количество ограничено.');
            return false;
        }
        $exists = $this->promoUserPromocodes->where('id', $promocode->id)->first();
        if (!is_null($exists)) {
            $this->setMessage('Промокод уже применен.');
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
}
