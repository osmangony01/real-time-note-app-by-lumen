<?php


namespace App\Traits;

use Illuminate\Http\Response;

use function response;

trait ApiResponse
{
    
    public function successResponse($data, $statusCode = Response::HTTP_OK)
    {
        //return response($data, $statusCode)->header('Content-Type', 'application/json');
        $data = json_decode($data, true);
        return response()->json(['notes' => $data , 'status' => $statusCode], $statusCode);
    }
    
    public function errorResponse($errorMessage, $statusCode)
    {
        return response()->json(['error' => $errorMessage, 'error_code' => $statusCode], $statusCode);
    }

    public function errorMessage($errorMessage, $statusCode)
    {
        return response($errorMessage, $statusCode)->header('Content-Type', 'application/json');
    }
}
