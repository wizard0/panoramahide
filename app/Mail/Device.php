<?php
/**
 * @copyright
 * @author
 */
namespace App\Mail;

use App\Models\Device as ModelDevice;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class for device.
 */
class Device extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var mixed
     */
    private $oUser;

    /**
     * @var array
     */
    private $data = [];

    /**
     * @var null|string
     */
    private $type;

    /**
     * Device constructor.
     * @param string $type
     * @param mixed $oUser
     * @param array $data
     */
    public function __construct(string $type, $oUser, array $data = [])
    {
        $this->oUser = $oUser;
        $this->data = $data;
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $result = null;
        $this->from(config('mail.from.address'), config('mail.from.name'));

        switch ($this->type) {
            case 'confirm':
                $title = config('app.name') . ' - Подтвердите устройство';
                $result = $this->view('email.device.confirm')->with([
                    'title' => $title,
                    'code' => $this->data['code'],
                    'oUser' => $this->oUser,
                ])->subject($title);
                break;
            case 'reset':
                $title = config('app.name') . ' - Сброс устройств';
                $result = $this->view('email.device.reset')->with([
                    'title' => $title,
                    'link' => $this->data['link'],//url('/'),
                    'oUser' => $this->oUser,
                ])->subject($title);
                break;
        }
        return $result;
    }
}
