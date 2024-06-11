<?php

namespace App\Http\Services;

use App\Http\Client\HttpClientInterface;
use Illuminate\Http\Request;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\GuzzleException;

class AnalyticsHttpService
{
    private const OPTIONS_QUERY = 'query';

    public function __construct(
        private readonly HttpClientInterface $httpClient
    ) {}

    /**
     * @param Request $request
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function scrapePrice(Request $request): ResponseInterface
    {
        $url = config('url.limitless-analytics') . '/scraper';

        return $this->httpClient->request(
            $request->getMethod(),
            $url,
            $this->prepareRequestOptions($request)
        );
    }

    /**
     * Prepare request options like query parameters and http headers
     * @param Request $request
     * @return array
     */
    private function prepareRequestOptions(Request $request): array
    {
        $options = [];
        parse_str($request->getQueryString(), $options[self::OPTIONS_QUERY]);

        return $options;
    }
}
