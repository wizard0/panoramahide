<?php
/**
 * Copyright (c) 2018-2019 "ИД Панорама"
 * Автор модуля: Дмитрий Поскачей (dposkachei@gmail.com)
 */

namespace Tests\Unit\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PromoUsersControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testIndex()
    {
        $this->assertTrue(true);
    }
}
