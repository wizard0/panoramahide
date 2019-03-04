<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class for paysystem.
 */
class Paysystem extends Model
{
    protected $table = 'paysystems';

    const ROBOKASSA = 'robokassa';
    const SBERBANK = 'sberbank';
    const INVOICE = 'invoice';

    public static function getByCode($code)
    {
        return self::where(['code' => $code])->first();
    }

    public function getDataValues()
    {
        $dataObj = (object)[];
        foreach ($this->data as $data) {
            $dataObj->{$data->code} = $data->value;
        }

        return $dataObj;
    }

    public function getDataNames()
    {
        $dataObj = (object)[];
        foreach ($this->data as $data) {
            $dataObj->{$data->code} = $data->name;
        }

        return $dataObj;
    }

    public function getDataAttributes()
    {
        $attributes = [];
        foreach ($this->data as $data) {
            $attributes[] = $data->code;
        }

        return $attributes;
    }

    public function getData()
    {
        $attributes = $this->getDataAttributes();
        $values = $this->getDataValues();
        $data = (object)[];

        foreach ($attributes as $attribute) {
            $data->{$attribute} = $values->{$attribute};
        }

        return $data;
    }

    public function data()
    {
        return $this->hasMany(PaysystemData::class);
    }
}
