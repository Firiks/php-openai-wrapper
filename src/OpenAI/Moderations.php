<?php

namespace Firiks\PhpOpenaiWrapper\OpenAI;

use Firiks\PhpOpenaiWrapper\OpenAI\Base\OpenAIBase;

class Moderations extends OpenAIBase
{
    public function __construct(\GuzzleHttp\Client $client, string $model, array $params = [])
    {
        parent::__construct($client, 'input', $model, $params);
    }

    /**
     * Classifies if text violates OpenAI's Content Policy.
     *
     * @param string $prompt
     * @param array $params
     *
     * @return object
     */
    public function createTextModeration(string $prompt, array $params = []): object
    {
        return $this->apiCall('POST', 'moderations', $prompt, $params);
    }
}
