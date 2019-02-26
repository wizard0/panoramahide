<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Http\Request;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use StylesTestTrait;

    /**
     * @param $data
     * @param $ajax
     * @return Request
     */
    protected function request(array $data = [], bool $ajax = false)
    {
        $request = new Request();
        $request->merge($data);

        if ($ajax) {
            $request->headers->set('X-Requested-With', 'XMLHttpRequest');
        }

        return $request;
    }
}
