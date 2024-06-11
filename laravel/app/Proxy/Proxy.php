<?php

namespace App\Proxy\Proxy;

use App\Http\Client\HttpClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class Proxy
{
    public function __construct(
        private HttpClientInterface $httpClient
    ) {}

    /**
     * @param string $method
     * @param string $uri
     * @param array $options
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function request(string $method, string $uri, array $options): ResponseInterface
    {
        return $this->httpClient->request($method, $uri, $options);
    }
}
