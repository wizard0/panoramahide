<?php

namespace App\Services\GetSetable;

use App\Models\PromoUser;

trait PromoUserGetSetableTrait
{
    /**
     * Promocode
     * @var null
     */
    private $promoUser = null;

    /**
     * @return PromoUser
     */
    public function promoUser(): PromoUser
    {
        return $this->promoUser;
    }

    /**
     * @param PromoUser $promoUser
     * @return $this
     */
    public function setPromoUser(PromoUser $promoUser)
    {
        $this->promoUser = $promoUser;

        return $this;
    }
}
