<?php

namespace App\Traits;

use Illuminate\Validation\ValidationException;

trait HttpResponses
{
    public function success(
        string $message = 'Request successful.',
        mixed $data = null,
        int $code = 200,
        array $meta = []
    ) {
        $res = [
            'status' => 'success',
            'responseCode' => '00',
            'message' => $message,
        ];

        if (!is_null($data)) {
            $res['data'] = $data;
        }

        if (!empty($meta)) {
            $res['meta'] = $meta;
        }

        return response()->json($res, $code);
    }

    public function error(
        string $message = 'Request failed.',
        array|int $errorsOrCode = [],
        int|string $codeOrResponseCode = 400,
        string $responseCode = '05'
    ) {
        $errors = [];
        $code = 400;

        if (is_array($errorsOrCode)) {
            $errors = $errorsOrCode;
            $code = is_int($codeOrResponseCode) ? $codeOrResponseCode : 400;
            $responseCode = is_string($codeOrResponseCode) ? $codeOrResponseCode : $responseCode;
        } elseif (is_int($errorsOrCode)) {
            $code = $errorsOrCode;
            $responseCode = is_string($codeOrResponseCode) ? $codeOrResponseCode : $responseCode;
        }

        $res = [
            'status' => 'error',
            'responseCode' => $responseCode,
            'message' => $message,
        ];

        if (!empty($errors)) {
            $res['errors'] = $errors;
        }

        return response()->json($res, $code);
    }


    // public function failed(ValidationException $e)
    // {
    //     $errors = $e->errors();
    //     $message = collect($errors)->flatten()->first() ?? 'Validation failed.';

    //     return $this->error(
    //         $message,
    //         $errors,
    //         422,
    //         '07'
    //     );
    // }


    /*
    |--------------------------------------------------------------------------
    | API Response Code Convention for Rex Business
    |--------------------------------------------------------------------------
    |
    | Use the following `responseCode` mapping consistently across your API
    | with "status": "error" for all error/failure responses:
    |
    | Status   | responseCode | HTTP Code | Meaning
    |----------|--------------|-----------|------------------------------------------
    | success  | "00"         | 200/201   | Request successful.
    | error    | "01"         | 400       | Bad Request (invalid payload).
    | error    | "02"         | 401       | Unauthorized (not logged in).
    | error    | "03"         | 403       | Forbidden (no permission).
    | error    | "04"         | 404       | Not Found (route/resource missing).
    | error    | "05"         | 405       | Method Not Allowed.
    | error    | "06"         | 409       | Conflict (duplicate/conflict).
    | error    | "07"         | 422       | Validation Error.
    | error    | "08"         | 429       | Too Many Requests (rate limit).
    | error    | "09"         | 500       | Internal Server Error.
    | error    | "10"         | 503       | Service Unavailable (maintenance).
    |
    | Example Usage:
    | - "02" => Use when user is not authenticated (HTTP 401).
    | - "07" => Use when validation fails (HTTP 422).
    | - "04" => Use when a resource or route is missing (HTTP 404).
    |
    | This ensures your frontend can reliably handle API responses,
    | show accurate error modals, and provide a consistent user experience.
    |
    */
}
