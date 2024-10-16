<?php

namespace App\Http\Traits;

/*
|--------------------------------------------------------------------------
| Api Respons Trait
|--------------------------------------------------------------------------
|
| This trait will be used for API response to clients.
|
*/

trait ApiResponse
{
    /**
     * Return a success JSON response.
     *
     * @param  array|string  $data
     * @param  string  $message
     * @param  int|null  $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success($data, string $message = '', int $code = 200)
    {
        return response()->json([
            'status' => 1,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * Return an error JSON response.
     *
     * @param  string  $message
     * @param  int  $code
     * @param  array|string|null  $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function error(string $message = '', int $code = 400)
    {
        return response()->json([
            'status' => 0,
            'message' => $message,
            'data' => null
        ], $code);
    }
}
