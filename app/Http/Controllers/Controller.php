<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function jsonResponseMustBeAjax()
    {
        return response()->json([
            'success' => false,
            'error' => true,
            'message' => 'The request must be AJAX'
        ]);
    }

    protected function jsonResponseValidationErrors(array $errors)
    {
        return response()->json([
            'success' => false,
            'error' => true,
            'message' => 'Validation messages',
            'errors' => $errors
        ]);
    }
}
