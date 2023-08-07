<?php

namespace Firiks\PhpOpenaiWrapper\OpenAI;

use Firiks\PhpOpenaiWrapper\OpenAI\Base\OpenAIBase;

class Chat extends OpenAIBase
{
    public function __construct(\GuzzleHttp\Client $client, string $model, array $params = [])
    {
        parent::__construct($client, 'messages', $model, $params);
    }

    /**
     * Creates a model response for the given chat conversation.
     *
     * @param array $data
     * @param array $params
     *
     * @return object
     */
    public function createChatCompletition(array $data = [], array $params = []): object
    {
        return $this->apiCall('POST', 'chat/completions', $data, $params);
    }
}
