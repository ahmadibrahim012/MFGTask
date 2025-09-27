<?php

namespace App\Traits;
use Illuminate\Http\Response;

trait APIResponse
{

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result,$message,$code=Response::HTTP_OK)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'code' => $code,
            'message' => $message,
        ];

        return response()->json($response, $code);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $code = 500)
    {
        $response = [
            'success' => false,
            'message' => $error,
            'code' => $code,
        ];

        return response()->json($response, $code);
    }


    public function generalError($code = 500)
    {
        $response = [
            'success' => false,
            'message' => "Oops! Something went wrong. Please contact your administrator for assistance.",
            'code' => $code,
        ];

        return response()->json($response, $code);
    }


}
