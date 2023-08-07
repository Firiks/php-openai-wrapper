<?php

namespace Firiks\PhpOpenaiWrapper\OpenAI;

use Firiks\PhpOpenaiWrapper\OpenAI\Base\OpenAIBase;

class Embeddings extends OpenAIBase
{
    public function __construct(\GuzzleHttp\Client $client, string $model, array $params = [])
    {
        parent::__construct($client, 'input', $model, $params);
    }

    /**
     * Create embeddings for a text prompt.
     *
     * @param string $prompt
     * @param array $params
     *
     * @return object
     */
    public function createEmbeddings(string $prompt, array $params = []): object
    {
        return $this->apiCall('POST', 'embeddings', $prompt, $params);
    }
}
