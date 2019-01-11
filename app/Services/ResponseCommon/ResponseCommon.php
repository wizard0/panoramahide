<?php

namespace App\Services\ResponseCommon;

use App\Services\Toastr\Toastr;
use BadMethodCallException;
use Illuminate\Support\Str;

class ResponseCommon
{
    /**
     * @var array
     */
    private $aData = [];

    /**
     * @var null
     */
    private $method = null;

    /**
     * Ajax return success with default properties
     *
     * @param array $aData
     * @return $this
     */
    public function success(array $aData = [])
    {
        $this->method = __FUNCTION__;

        $this->aData = array_merge([
            'success' => true
        ], $aData);

        return $this;
    }

    /**
     * Ajax return error with default properties
     *
     * @param array $aData
     * @return $this
     */
    public function error(array $aData = [])
    {
        $this->method = __FUNCTION__;

        $this->aData = array_merge([
            'success' => false
        ], $aData);

        return $this;
    }

    /**
     * Ajax return json error with status 422
     *
     * @param $text
     * @param string $key
     * @return \Illuminate\Http\JsonResponse
     */
    public function jsonError($text, $key = 'error')
    {
        return response()->json([
            $key => [$text]
        ], 422);
    }

    /**
     * @param $message
     * @return $this
     */
    public function withMessage($message)
    {
        $this->aData['toastr'] = (new Toastr($message))->{$this->method}();

        return $this;
    }

    /**
     * @return array
     */
    public function build()
    {
        return $this->aData;
    }

    /**
     * @param $method
     */
    public function setMethod($method)
    {
        $this->method = in_array($method, ['success', 'error', 'warning', 'info']) ? $method : $this->method;
    }
}
