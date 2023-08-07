<?php

namespace Firiks\PhpOpenaiWrapper\OpenAI\Base;

use Firiks\PhpOpenaiWrapper\Http\Request;

class OpenAIBase extends Request
{
    protected array $params;
    protected string $method;
    protected ?string $inputType;
    protected ?string $model;

    public function __construct(\GuzzleHttp\Client $client, ?string $inputType, ?string $model, array $params = [])
    {
        parent::__construct($client);

        $this->inputType = $inputType;
        $this->model = $model;
        $this->params = $params;
    }

    protected function apiCall(string $method, string $endpoint, array|string $data, array $params = []): object
    {
        $body = [];

        if ($this->inputType && $data) {
            if (is_array($data)) {
                $body[$this->inputType] = $data;
            } elseif (is_string($data)) {
                $body[$this->inputType] = $data;
            }
        }

        // merge the params
        $body = array_merge($body, $this->params);

        // merge any optional params
        $body = array_merge($body, $params);

        // set the model
        if ($this->model && !isset($body['model'])) {
            $body['model'] = $this->model;
        }

        if ($method === 'POST' || $method === 'PUT') {
            $body = [
                'body' => \json_encode($body),
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
            ];
        }

        // make the request
        $json = $this->request($method, $endpoint, $body);

        // return the json
        return $json;
    }
}
