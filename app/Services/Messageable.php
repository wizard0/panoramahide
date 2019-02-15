<?php

namespace App\Services;


trait Messageable
{
    /**
     * Сообщение с текстом ошибки
     *
     * @var null
     */
    private $message = null;

    /**
     * @param $message
     */
    private function setMessage(string $message) : void
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getMessage() : ?string
    {
        return $this->message;
    }
}
