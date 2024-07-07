<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use App\Exceptions\ResourceDoesNotExist;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * @param $request
     * @param Throwable $e
     * @return JsonResponse
     */
    public function render($request, Throwable $e): JsonResponse
    {
        if ($e instanceof ResourceDoesNotExist) {
            return $this->handleResourceDoesNotExist($e);
        }

        $defaultPublicMessage = 'Unknown Exception';
        Log::error($defaultPublicMessage . ': ' . $e->getMessage());

        return response()->json([
            'message' => $defaultPublicMessage
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function handleResourceDoesNotExist(ResourceDoesNotExist $exception): JsonResponse
    {
        $errorMessage = "Resource does not exist";

        Log::error($exception->getMessage());

        return response()->json([
            'message' => $errorMessage
        ], Response::HTTP_NOT_FOUND);
    }

}
