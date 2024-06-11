<?php

namespace App\Http\Client;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class HttpClient implements HttpClientInterface
{
    private GuzzleHttpClient $httpClient;

    public function __construct(GuzzleHttpClient $httpClient) {
        $this->httpClient = new $httpClient();
    }

    public function send(RequestInterface $request, array $options = []): ResponseInterface
    {
        return $this->httpClient->send($request, $options);
    }

    public function sendAsync(RequestInterface $request, array $options = []): PromiseInterface
    {
        return $this->httpClient->sendAsync($request, $options);
    }

    public function request(string $method, $uri, array $options = []): ResponseInterface
    {
        return $this->httpClient->request($method, $uri, $options);
    }

    public function requestAsync(string $method, $uri, array $options = []): PromiseInterface
    {
        return $this->httpClient->requestAsync($method, $uri, $options);
    }

    public function getConfig(string $option = null)
    {
        return $this->httpClient->getConfig($option);
    }
}