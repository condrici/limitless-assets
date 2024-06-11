<?php

namespace App\Http\Controllers;

use App\Exceptions\UpstreamException;
use App\Http\Services\AnalyticsHttpService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class AnalyticsController extends Controller
{
    public function __construct(
       private readonly AnalyticsHttpService $analyticsHttpService
    ) {}

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws UpstreamException
     */
    public function scrapePrice(Request $request): JsonResponse
    {
        try {
            # If upstream server returns HTTP 4XX|5XX $response will throw an exception
            $response = $this->analyticsHttpService->scrapePrice($request);
            return response()->json(
                json_decode($response->getBody()->getContents()),
                $response->getStatusCode()
            );
        } catch (Throwable $exception) {
            // message, httpClientException, httpServerResponse
            throw new UpstreamException(
                message: 'Price scraping failed',
                previous: $exception
            );
        }
    }
}
