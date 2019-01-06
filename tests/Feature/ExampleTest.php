<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ExampleTest extends TestCase
{
    public function testMainPage()
    {
        $_SERVER['REQUEST_URI'] = '/';

        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Test /promo page
     *
     * @return void
     */
    public function testPromoPage()
    {
        $_SERVER['REQUEST_URI'] = '/promo';

        $response = $this->get('/promo');

        $response->assertStatus(200);
    }
}
