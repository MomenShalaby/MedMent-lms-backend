<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait HttpResponses
{
    protected function success($data, $message = null, $code = 200, $pagination = false)
    {
        $responseData = [
            'status' => 'Request was successful.',
            'message' => $message,
            'data' => $data,
        ];

        if ($pagination) {
            $pagination = [
                'current_page' => $data->currentPage(),
                'per_page' => $data->perPage(),
                'total' => $data->total(),
                'last_page' => $data->lastPage(),
            ];

            $responseData['pagination'] = $pagination;
        }

        return response()->json($responseData, $code);

    }
    protected function error($message, $code = 500)
    {
        return response()->json([
            'status' => 'Error',
            'message' => $message,
        ], $code);
    }
}
