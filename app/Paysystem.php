<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paysystem extends Model
{
    protected $table = 'paysystems';

    const ROBOKASSA = 'robokassa';
    const SBERBANK = 'sberbank';
    const INVOICE = 'invoice';

    public static function getByCode($code) {
        return self::where(['code' => $code])->first();
    }

    public function getData() {
        $data = [];
        switch ($this->code) {
            case self::ROBOKASSA:
                $data = (object) [
                    'login' => 'demo',
                    'pass' => 'password_1',
                    'description' => 'Вы хотите оплатить через систему <b>www.roboxchange.net</b>',
                ];
                break;
            case self::SBERBANK:

                break;

            case self::INVOICE:

                break;
        }

        return $data;
    }
}
