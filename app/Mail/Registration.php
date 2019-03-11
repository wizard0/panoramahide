<?php
/*
 * Copyright (c) 2018-2019 "ИД Панорама"
 * Автор модуля: Илья Картунин (ikartunin@gmail.com)
 */
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Registration extends Mailable
{
    use Queueable, SerializesModels;

    private $email = [];
    private $password = [];

    public function __construct($email, $password)
    {
        $this->email    = $email;
        $this->password = $password;
    }

    public function build()
    {
        $result = null;
        $this->from(config('mail.from.address'), config('mail.from.name'));
        $title = config('app.name') . ' Поздравляем с успешной регистрацией!';
        $result = $this->view('email.registration.index')->with([
            'title'    => $title,
            'email'    => $this->email,
            'password' => $this->password,
        ])->subject($title);

        return $result;
    }
}
