<?php
namespace App\Traits;

use Exception;

trait Helper{
    function invalidRequest($message = '')
    {
        return $this->sendResponse(false, null, 400, $message);
    }
    function sendResponse($status, $data, $code, $messages = 'Non message')
    {
        if($status === true)
            return response()->json([
                'status' => $status,
                'data' => $data,
                'messages' => $messages
            ], $code);
        else if($status === false)
            return response()->json([
                'status' => $status,
                'error' => $data,
                'messages' => $messages
            ], $code);
        else
            return Exception::class;
    }
}
