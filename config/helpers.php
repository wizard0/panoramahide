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
