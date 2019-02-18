<?php

namespace App\Mail;

use App\Models\UserDevice;
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
     * @var UserDevice|null
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
    public function __construct(string $type, User $oUser, ?UserDevice $oDevice = null)
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
        $from = [
            'address' => config('mail.from.address'),
            'name' => config('mail.from.name'),
        ];

        switch ($this->type) {
            case 'confirm':
                $title = config('app.name').' - Подтвердите устройство';
                return $this->view('email.device.confirm')->with([
                    'title' => $title,
                    'oUser' => $this->oUser,
                    'oDevice' => $this->oDevice,
                ])->subject($title)->from($from['address'], $from['name']);
                break;
            case 'reset':
                $title = config('app.name').' - Сброс устройств';
                return $this->view('email.device.reset')->with([
                    'title' => $title,
                    'link' => url('/'),
                    'oUser' => $this->oUser,
                ])->subject($title)->from($from['address'], $from['name']);
                break;
            default:
                return null;
                break;
        }
    }
}
