<?php

namespace App\Mail;

use App\Models\Device as ModelDevice;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Device extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    private $oUser;

    /**
     * @var ModelDevice|null
     */
    private $oDevice = null;

    /**
     * @var null|string
     */
    private $type;

    /**
     * Device constructor.
     * @param $type
     * @param $oUser
     * @param $oDevice
     */
    public function __construct(string $type, User $oUser, ?ModelDevice $oDevice = null)
    {
        $this->oUser = $oUser;
        $this->oDevice = $oDevice;
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->from(config('mail.from.address'), config('mail.from.name'));

        switch ($this->type) {
            case 'confirm':
                $title = config('app.name').' - Подтвердите устройство';
                return $this->view('email.device.confirm')->with([
                    'title' => $title,
                    'code' => $this->oDevice->activate_code,
                    'oUser' => $this->oUser,
                ])->subject($title);
                break;
            case 'reset':
                $title = config('app.name').' - Сброс устройств';
                return $this->view('email.device.reset')->with([
                    'title' => $title,
                    'link' => url('/'),
                    'oUser' => $this->oUser,
                ])->subject($title);
                break;
            default:
                return null;
                break;
        }
    }
}
