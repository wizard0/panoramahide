<?php
/**
 * Copyright (c) 2018-2019 "ИД Панорама"
 * Автор модуля: Дмитрий Поскачей (dposkachei@gmail.com)
 */

namespace Tests;


use App\Models\User;
use Illuminate\Http\Request;

trait CommonTestTrait
{
    /**
     * @var User
     */
    protected $oUser;

    /**
     * @param $data
     * @param $ajax
     * @return Request
     */
    protected function request(array $data = [], bool $ajax = false)
    {
        $request = new Request();
        $request->merge($data);
        $request->merge([
            'phpunit' => true,
        ]);

        if ($ajax) {
            $request->headers->set('X-Requested-With', 'XMLHttpRequest');
        }

        return $request;
    }

    protected function postAjax($url, $data = [])
    {
        return $this->post($url, $data, array('HTTP_X-Requested-With' => 'XMLHttpRequest'));
    }
}
