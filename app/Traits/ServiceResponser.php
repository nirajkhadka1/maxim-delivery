<?php

namespace App\Traits;

trait ServiceResponser
{

    public function successReponse($message, $code = 200)
    {
        return response()->json([
            'error' => false,
            'status' => $code,
            'response' => $message
        ],$code);
    }

    public function errorResponse($message, $code = 500)
    {
        return response()->json([
            'error' => false,
            'status' => $code,
            'response' => $message
        ],$code ?? 500);
    }
}
