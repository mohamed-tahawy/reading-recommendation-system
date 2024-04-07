<?php
namespace App\Traits;

use Illuminate\Support\Facades\Response;

trait ResponseHandel
{
    public function successResponse($data = new \stdClass, $message = null, $status =200)
    {
        return Response::json([
            'success' => true,
            'message' => $message,
            'data' => $data ?? new \stdClass,            
        ], $status);
    }

    public function errorResponse($data = new \stdClass,$message = null, $status = 400)
    {
        return Response::json([
            'success' => false,
            'message' => $message,
            'data' => $data ?? new \stdClass
        ], $status);
    }
}
