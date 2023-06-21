<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class BaseController extends Controller
{
    /**
     * success response method.
     * @param mixed $result - Result of data. Can be object, array, collection
     * @param string $message - Message of success response
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendRespond(mixed $result, string $message)
    {
        $response = [
            'message' => $message,
            'data' => $result,
        ];
        
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * success response method for transactional data.
     * @param string $message - Message of success response
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendRespondCreated(string $message)
    {
        $response = [
            'message' => $message,
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    
    /**
     * return error response.
     * @param string $error - Error message
     * @param mixed $errorData - option error messages. A few error messages
     * @return \Illuminate\Http\JsonResponse
     */

    public function sendError(string $error, mixed $errorData = [])
    {
        $response = [
            'message' => $error,
            'errors'  => (empty($errorData)) ? "Server Error!" : $errorData
        ];

        return response()->json($response, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * return unauthorized response.
     * @param string $error - Error message
     * @param mixed $errorData - option error messages. A few error messages
     * @return \Illuminate\Http\JsonResponse
     */

    public function sendUnauthorized(string $error, mixed $errorData = [])
    {
        $response = [
            'message' => $error,
            'errors'  => (empty($errorData)) ? "Unauhorized!" : $errorData
        ];

        return response()->json($response, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * return bad request response.
     * @param string $error - Error message
     * @param mixed $errorMessages - option error messages. A few error messages
     * @return \Illuminate\Http\JsonResponse
     */

    public function sendBadRequest(string $error, mixed $errorData = [])
    {
        $response = [
            'message' => $error,
            'errors'  => (empty($errorData)) ? "Bad Request" : $errorData
        ];

        return response()->json($response, Response::HTTP_BAD_REQUEST);
    }
}
