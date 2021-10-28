<?php

namespace App\Http\Controllers;

use App\Common\Constants;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param array $data
     * @param int   $httpStatusCode
     * @param array $header
     *
     * @return JsonResponse
     */
    protected function sendSuccess(array $data, int $httpStatusCode = 200, array $header = []): JsonResponse
    {
        $responseData = [
            Constants::STATUS => Constants::SUCCESS,
            Constants::DATA => $data,
        ];

        return $this->sendResponse($responseData, $httpStatusCode, $header);
    }

    /**
     * @param string $message
     * @param int    $code
     * @param int    $httpStatusCode
     * @param array  $header
     *
     * @return JsonResponse
     */
    protected function sendError(string $message, int $code, int $httpStatusCode = 500, array $header = []): JsonResponse
    {
        $responseData = [
            Constants::STATUS => Constants::ERROR,
            Constants::RESPONSE_MESSAGE => $message,
            Constants::CODE => $code,
        ];

        return $this->sendResponse($responseData, $httpStatusCode, $header);
    }

    /**
     * @param array $data
     * @param int   $httpStatusCode
     * @param array $header
     *
     * @return JsonResponse
     */
    private function sendResponse(array $data, int $httpStatusCode, array $header = []): JsonResponse
    {
        $response = response()->json($data)->setStatusCode($httpStatusCode);

        foreach ($header as $key => $value) {
            $response->header($key, $value);
        }

        return $response;
    }
}
