<?php

namespace App\Services\ResponseCommon;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

/**
 * Class for response common helpers.
 */
class ResponseCommonHelpers
{
    /**
     * Ajax return success with default properties
     *
     * return $this->success([], 'Message')
     *
     * @param array $aData
     * @param null $message
     * @return array
     */
    public function success(array $aData = [], $message = null)
    {
        $success = (new ResponseCommon())->success($aData);

        if (!is_null($message)) {
            $success = $success->withMessage($message);
        }
        return $success->build();
    }

    /**
     * Ajax return error with default properties
     *
     * return $this->error([
     *
     * ], 'Message')
     *
     * @param array $aData
     * @param null $message
     * @return array
     */
    public function error(array $aData = [], $message = null) : array
    {
        $success = (new ResponseCommon())->error($aData);

        if (isset($aData['type'])) {
            $success->setMethod($aData['type']);
        }

        if (!is_null($message)) {
            $success = $success->withMessage($message);
        }
        return $success->build();
    }

    /**
     * Ajax return json error with status 422
     *
     * @param array $aData
     * @return JsonResponse
     */
    public function jsonError(array $aData = [])
    {
        return response()->json($aData, 422);
    }

    /**
     * Log info with CPU value
     *
     * @param string $message
     */
    public function cpuLog($message = '')
    {
        $load = sys_getloadavg();
        info(json_encode($load) . ' - ' . $message);
    }

    /**
     * Log info with memory value
     *
     * @param string $message
     */
    public function memoryUsageLog($message = '')
    {
        $load = memory_get_usage();
        info(json_encode($load) . ' - ' . $message);
    }

    /**
     * Обертка для валидатора
     *
     * @param array $data
     * @param array $rules
     * @param array $messages
     * @param array $customAttributes
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validation(array $data, array $rules, array $messages = [], array $customAttributes = [])
    {
        return Validator::make($data, $rules, $messages, $customAttributes);
    }

    /**
     * Вытащить все сообщения об ошибках
     *
     * @param null $validation
     * @param array $errors
     * @param array $data
     * @return JsonResponse
     */
    public function validationMessages($validation = null, $errors = [], $data = [])
    {
        $messages = [];
        if (!is_null($validation)) {
            $aMessages = $validation->getMessageBag()->toArray();

            foreach ($aMessages as $key => $aMessage) {
                $messages[$key] = $aMessage[0];
            }
        }
        $messages = array_merge($messages, $errors);
        $returnData = [
            'success' => false,
            'errors' => $messages,
        ];
        if (!empty($data)) {
            $returnData = array_merge($returnData, $data);
        }
        return $this->jsonError($returnData);
    }

    /**
     * Для отправки ошибки, что запрос не ajax
     *
     * @return JsonResponse
     */
    public function mustBeAjax() : JsonResponse
    {
        return response()->json([
            'success' => false,
            'error' => true,
            'message' => 'The request must be AJAX'
        ]);
    }
}
