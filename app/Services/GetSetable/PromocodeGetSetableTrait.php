<?php

namespace App\Services\GetSetable;

use App\Models\Promocode;

trait PromocodeGetSetableTrait
{
    /**
     * Promocode
     * @var null
     */
    private $promocode = null;

    /**
     * @return Promocode
     */
    public function promocode(): Promocode
    {
        return $this->promocode;
    }

    /**
     * @param Promocode $promocode
     * @return $this
     */
    public function setPromocode(Promocode $promocode)
    {
        $this->promocode = $promocode;

        return $this;
    }
}
