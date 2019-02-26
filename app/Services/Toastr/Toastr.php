<?php

namespace App\Services\Toastr;

use Bulk\Toastr\Facades\Toastr as ToastrFacade;

/**
 * Class for toastr.
 */
class Toastr
{
    private $toastrMessages = [
        'success' => [
            'title' => 'Успех',
            'text' => 'Данные успешно добавлены',
            'type' => 'success'
        ],
        'info' => [
            'title' => 'Информация',
            'text' => 'Данные успешно добавлены',
            'type' => 'info'
        ],
        'warning' => [
            'title' => 'Внимание',
            'text' => 'Данные успешно добавлены',
            'type' => 'warning'
        ],
        'primary' => [
            'title' => 'И так',
            'text' => 'Данные успешно добавлены',
            'type' => 'primary'
        ],
        'error' => [
            'title' => 'Ошибка',
            'text' => 'Данные успешно добавлены',
            'type' => 'error'
        ],
    ];

    private $message = '';

    public function __construct($message)
    {
        $this->message = $message;
    }

    private function get($type, $json = true)
    {
        $this->toastrMessages[$type]['text'] = $this->message;
        if (!$json) {
            $data['options'] = [
                'timeOut' => 5000
            ];
            $data = array_merge($data, $this->toastrMessages[$type]);
            if ($type === 'primary') {
                $type = 'info';
            }
            return ToastrFacade::{$type}($data['text'], $data['title'], $data['options']);
        }
        return $this->toastrMessages[$type];
    }


    public function success($json = true)
    {
        return $this->get('success', $json);
    }

    public function error($json = true)
    {
        return $this->get('error', $json);
    }

    public function info($json = true)
    {
        return $this->get('info', $json);
    }

    public function warning($json = true)
    {
        return $this->get('warning', $json);
    }

    public function primary($json = true)
    {
        return $this->get('primary', $json);
    }
}
