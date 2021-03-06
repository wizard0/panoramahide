<?php

if (!function_exists('responseCommon')) {

    function responseCommon()
    {
        return (new \App\Services\ResponseCommon\ResponseCommonHelpers());
    }
}

if (!function_exists('testData')) {

    function testData()
    {
        return (new \Tests\Seeds\CommonTestData());
    }
}

if (!function_exists('phoneFormat')) {
    /**
     * Форматировать номер телефона
     *
     * @param      string  $value  Номер телефона
     *
     * @return     string  Форматированный номер телефона
     */
    function phoneFormat($value)
    {
        $num = preg_replace('/[^0-9]/', '', $value);
        $len = strlen($num);

        if ($len === 5) {
            $num = preg_replace('/([0-9]{1})([0-9]{2})([0-9]{2})/', '$1-$2-$3', $num);
        } elseif ($len === 6) {
            $num = preg_replace('/([0-9]{2})([0-9]{2})([0-9]{2})/', '$1-$2-$3', $num);
        } elseif ($len === 7) {
            $num = preg_replace('/([0-9]{3})([0-9]{2})([0-9]{2})/', '$1-$2-$3', $num);
        } elseif ($len === 11) {
            $num = preg_replace('/([0-9]{1})([0-9]{3})([0-9]{3})([0-9]{2})([0-9]{2})/', '+$1 ($2) $3-$4-$5', $num);
        }
        return $num;
    }
}

if (!function_exists('halfyear')) {

    function halfyear($month)
    {
        if ($month < 6) {
            return \App\Models\Subscription::HALFYEAR_1;
        } else {
            return \App\Models\Subscription::HALFYEAR_2;
        }
    }
}

if (!function_exists('bladeHelper')) {
    function bladeHelper()
    {
        return (new \App\Services\BladeHelper());
    }
}
