<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    protected function confirmUser($user) :JsonResponse
    {
        if (!$user) {
            return $this->sendError('Validation Error.', ['status' => 'failed', 'message' => 'user not found'], 419);       
        }
    }
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message) :JsonResponse
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];

        Log::info($message, $response);

        return response()->json($response, 200);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404) :JsonResponse
    {
    	$response = [
            'success' => false,
            'message' => $error,
            'status_code' => $code,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        Log::error($error, $response);

        return response()->json($response, $code);
    }
}


What’s up guys! Samuel here — 
Welcome to my channel
This is my first video...
I am full-stack developer, trying to make coding simple. 
Hit Subscribe and let’s code!

