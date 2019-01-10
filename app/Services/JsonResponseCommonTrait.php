<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;

trait JsonResponseCommonTrait
{
    /**
     * Валидационная ошибка
     *
     * @param array $errors
     * @return JsonResponse
     */
    protected function jsonResponseValidationErrors(array $errors = []) : JsonResponse
    {
        return response()->json([
            'success' => false,
            'error' => true,
            'message' => 'Validation messages',
            'errors' => $errors
        ]);
    }
}
