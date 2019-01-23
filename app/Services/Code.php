<?php

namespace App\Services;

use App\Models\Activations;

class Code
{
    /**
     * @var int
     */
    private $confirmationPromoCodeLength = 6;

    /**
     * @return int
     */
    public function getConfirmationPromoCode() : int
    {
        $from = '';
        $to = '';
        for ($i = 0; $i < $this->confirmationPromoCodeLength; $i++) {
            $from .= $i === 0 ? '1' : '0';
            $to .= '9';
        }
        $from = intval($from);
        $to = intval($to);
        return mt_rand($from, $to);
    }

    /**
     * @param $code
     * @return array
     */
    public function sendConfirmationPromoCode($code)
    {
        return [
            'success' => true,
        ];
    }
}
