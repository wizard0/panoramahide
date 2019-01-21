<?php

namespace Tests\Unit\Services;


use App\Services\Code;
use Tests\TestCase;

class CodeTest extends TestCase
{
    /**
     * Тестирование генерации кода подтверждения
     */
    public function testCode()
    {
        $oCode = (new Code());
        $code = $oCode->getConfirmationPromoCode();

        $this->assertIsInt($code);

        $this->assertTrue($code >= 100000 && $code <= 999999);
    }
}
