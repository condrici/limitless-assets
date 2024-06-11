<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
        if ($e instanceof UpstreamException) {
            return $this->handleUpstreamException($e);
        }

        $defaultPublicMessage = 'Unknown Exception';
        Log::error($defaultPublicMessage . ': ' . $e->getMessage());

        return response()->json([
            'message' => $defaultPublicMessage
        ], 500);
    }

    /**
     * UpstreamException handling
     * Logging: both the internal error message and the upstream error message
     * Outputting: only the internal error message
     *
     * @param UpstreamException $exception
     * @return JsonResponse
     */
    private function handleUpstreamException(UpstreamException $exception): JsonResponse
    {
        $errorMessage = $exception->getMessage();
        $upstreamErrorMessage = $exception->getPrevious()->getMessage();

        Log::error(
            sprintf(
                "\n---\n Upstream Exception: \n (Internal Error) %s \n (Upstream Error) %s---",
                $errorMessage, $upstreamErrorMessage
            )
        );

        return response()->json([
            'message' => $errorMessage
        ], 500);
    }

}
