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

    public function getDataValues() {
        $dataObj = (object) [];
        foreach ($this->data as $data)
            $dataObj->{$data->code} = $data->value;

        return $dataObj;
    }

    public function getDataNames() {
        $dataObj = (object) [];
        foreach ($this->data as $data)
            $dataObj->{$data->code} = $data->name;

        return $dataObj;
    }

    public function getDataAttributes() {
        $attributes = [];
        foreach ($this->data as $data)
            $attributes[] = $data->code;

        return $attributes;
    }

    public function data() {
        return $this->hasMany(PaysystemData::class);
    }
}
