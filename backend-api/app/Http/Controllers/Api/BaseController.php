<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function responseOk($result, $code = 200, $message = "Success")
    {
        $response = [
            'code'    => $code,
            'message' => $message,
            'data'    => $result
        ];

        return response()->json($response, $code);
    }

    public function responseError($error, $code = 422, $errorDetail = [])
    {
        $response = [
            'code'    => $code,
            'error' => $error,
        ];

        if (!empty($errorDetail)) {
            $response["errorDetail"] = $errorDetail;
        }

        return response()->json($response, $code);
    }
}
