<?php

namespace App\Mail;

use App\Models\Journal;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Recommend extends Mailable
{
    use Queueable, SerializesModels;

    public $links;
    public $emailFrom;

    public function __construct($emailFrom, $links)
    {
        $this->emailFrom = $emailFrom;

        $this->links = $links;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.recommend');
    }
}
