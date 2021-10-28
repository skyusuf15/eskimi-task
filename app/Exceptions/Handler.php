<?php

namespace App\Exceptions;

use App\Common\Constants;
use App\Common\ResponseCodes;
use App\Common\ResponseMessages;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }


    /**
     * @param Request $request
     * @param Throwable $throwable
     * @return JsonResponse|Response|object|\Symfony\Component\HttpFoundation\Response
     * @throws Throwable
     */
//    public function render($request, Throwable $throwable)
//    {
//        if (!$request->wantsJson()) {
//            return parent::render($request, $throwable);
//        }
//
//        switch ($throwable::class) {
//            case ValidationException::class:
//                $error[Constants::RESPONSE_MESSAGE] = ResponseMessages::INVALID_PARAMS;
//                $error[Constants::CODE] = ResponseCodes::BAD_REQUEST;
//                $messages = [];
//                foreach ($throwable->errors() as $key => $message) {
//                    $messages = array_merge($messages, $message);
//                }
//                $error[Constants::DATA] = $messages;
//                $statusCode = ResponseCodes::BAD_REQUEST;
//                break;
//            default:
//                $statusCode = $this->getStatusCode($throwable);
//                $error = [
//                    Constants::STATUS => Constants::ERROR,
//                    Constants::RESPONSE_MESSAGE => $this->getExceptionMessage($throwable),
//                    Constants::CODE  => $statusCode,
//                ];
//        }
//
//        if (config('app.debug')) {
//            $error["exception_message"] = $throwable->getMessage();
//            $error[Constants::TRACE] = $throwable->getTraceAsString();
//        }
//
//        return response()->json($error)->setStatusCode($statusCode);
//    }

    private function getExceptionMessage(Throwable $throwable): string
    {
        if ($throwable instanceof HttpException) {
            return sprintf('%s', Response::$statusTexts[$throwable->getStatusCode()]);
        }

        return $throwable->getMessage() ?? ResponseMessages::ERROR_PROCESSING_REQUEST;
    }

    private function getStatusCode(Throwable $throwable): int
    {
        return $throwable->getCode() ?? ResponseCodes::INTERNAL_SERVER_ERROR;
    }
}
