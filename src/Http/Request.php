<?php

namespace Firiks\PhpOpenaiWrapper\Http;

abstract class Request
{
    private \GuzzleHttp\Client $client;

    public function __construct(\GuzzleHttp\Client $client)
    {
        $this->client = $client;
    }

    /**
     * Make a HTTP request
     *
     * @param string $method
     * @param string $endpoint
     * @param array $options
     *
     * @return object|string
     */
    protected function request(string $method, string $endpoint, array $options = [], bool $json = true): object|string
    {
        $response = $this->client->request($method, $endpoint, $options);
        $body = $response->getBody();

        if (isset($_ENV['DEBUG']) && $_ENV['DEBUG'] == 'true') {
            $headers = $response->getHeaders();
            echo "DEBUG: Response Headers\n";
            print_r($headers);
        }

        if ($json) {
            $json = \json_decode($body);
            return $json;
        }

        return $body->getContents();
    }

    /**
     * Make a HTTP request asynchronously
     *
     * @param string $method
     * @param string $endpoint
     * @param array $options
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    protected function requestAsync(string $method, string $endpoint, array $options = []): \GuzzleHttp\Promise\PromiseInterface
    {
        $promise = $this->client->requestAsync($method, $endpoint, $options);

        return $promise;
    }
}
