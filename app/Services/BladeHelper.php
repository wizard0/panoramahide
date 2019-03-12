<?php

namespace App\Services;

class BladeHelper
{
    /**
     *
     * @param string $oItem
     * @return string
     * @throws \Throwable
     */
    public function popover($oItem)
    {
        return view('components.journal.popover', [
            'oItem' => $oItem
        ])->render();
    }
}
