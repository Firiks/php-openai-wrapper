<?php

namespace Firiks\PhpOpenaiWrapper\OpenAI;

use Firiks\PhpOpenaiWrapper\OpenAI\Base\OpenAIBase;

class Completions extends OpenAIBase
{
    public function __construct(\GuzzleHttp\Client $client, string $model, array $params = [])
    {
        parent::__construct($client, 'prompt', $model, $params);
    }

    /**
     * Create a text completion based on a prompt.
     *
     * @param string $prompt
     * @param array $params
     *
     * @return object
     */
    public function createPromptCompletition(string $prompt, array $params = []): object
    {
        return $this->apiCall('POST', 'completions', $prompt, $params);
    }
}
