<?php

namespace App\Traits;

trait AjaxResponse
{
    /**
     * The function "success" is used to generate a JSON response with a success status code, message,
     * and optional data.
     *
     * return a JSON response with the specified status code, message, and data.
     */
    protected function success($statusCode,$message,$data = null)
    {
        $successMessages = [
            200 => 'Success',
            201 => 'Created!',
            204 => 'No Content!',
            // Add more status codes and messages as needed
        ];

        if (array_key_exists($statusCode, $successMessages)) {
            $response = [
                'status' => $statusCode,
                'message' => $message != "" ? $message : $successMessages[$statusCode],
                'data' => $data,
            ];

            return response()->json($response);
        } else {
            return $this->error('Invalid success code!', 400);
        }
    }

    /**
     * The function "error" is used to generate a JSON response with a error status code, message,
     * and optional data.
     *
     * return a JSON response with the specified status code, message, and data.
     */
    protected function error($statusCode,$message,$data = null)
    {
        $errorMessages = [
            400 => 'Bad Request!',
            401 => 'Unauthorized!',
            404 => 'Not Found!',
            // Add more status codes and messages as needed
        ];

        if (array_key_exists($statusCode, $errorMessages)) {
            $response = [
                'status' => $statusCode,
                'message' => $message != "" ? $message : $errorMessages[$statusCode],
                'data' => $data,
            ];

            return response()->json($response);
        } else {
            return $this->error('Invalid error code!', 500);
        }
    }
}
