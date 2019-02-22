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
     * @return Request
     */
    protected function request(array $data = [])
    {
        $request = new Request();
        $request->merge($data);
        return $request;
    }
}
