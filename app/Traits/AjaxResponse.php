<?php

namespace App\Traits;

trait AjaxResponse
{
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
