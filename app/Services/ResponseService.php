<?php

namespace App\Services;

use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Response as FacadesResponse;
use App\Constants\AppMessages;

class ResponseService
{
    public function successResponse($data = null, $message = AppMessages::REQUEST_SUCCESSFUL, $code = HttpResponse::HTTP_OK)
    {
        return FacadesResponse::json([
            'status' => true,
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public function errorResponse($message = AppMessages::INTERNAL_SERVER_ERROR, $code = HttpResponse::HTTP_INTERNAL_SERVER_ERROR)
    {
        return FacadesResponse::json([
            'status' => false,
            'code' => $code,
            'message' => $message,
            'data' => null,
        ], $code);
    }

    public function notFoundResponse($message = AppMessages::RESOURCE_NOT_FOUND, $code = HttpResponse::HTTP_NOT_FOUND)
    {
        return FacadesResponse::json([
            'status' => false,
            'code' => $code,
            'message' => $message,
            'data' => null,
        ], $code);
    }
}
