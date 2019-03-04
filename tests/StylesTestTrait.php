<?php
/**
 * @copyright
 * @author
 */

namespace Tests;

/**
 * Сервисные методы
 */
trait StylesTestTrait
{
    /**
     * Вывод в консоли красным цветом
     *
     * @param $message
     * @return string
     */
    public function textRed($message)
    {
        return "\033[97;41m" . $message . "\033[0;39m";
    }
}
