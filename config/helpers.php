<?php

if (!function_exists('responseCommon')) {

    function responseCommon()
    {
        return (new \App\Services\ResponseCommon\ResponseCommonHelpers());
    }
}
