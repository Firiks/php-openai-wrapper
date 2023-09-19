<?php

namespace Firiks\PhpOpenaiWrapper;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleRetry\GuzzleRetryMiddleware;

use Firiks\PhpOpenaiWrapper\OpenAI\Chat;
use Firiks\PhpOpenaiWrapper\OpenAI\DallE;
use Firiks\PhpOpenaiWrapper\OpenAI\Files;
use Firiks\PhpOpenaiWrapper\OpenAI\Models;
use Firiks\PhpOpenaiWrapper\OpenAI\Whisper;
use Firiks\PhpOpenaiWrapper\OpenAI\FineTunes;
use Firiks\PhpOpenaiWrapper\OpenAI\Embeddings;
use Firiks\PhpOpenaiWrapper\OpenAI\Completions;
use Firiks\PhpOpenaiWrapper\OpenAI\Moderations;

final class PhpOpenaiWrapper
{
    /**
     * @var string
     */
    private $apiVersion;

    /**
     * @var string
     */
    private $org;

    /**
     * @var Client
     */
    private Client $guzzleClient;

    public function __construct(string $apiKey, string $org = '', string $apiVersion = 'v1', int $retryCount = 0)
    {

        $this->apiVersion = $apiVersion;
        $this->org = $org;

        // default headers
        $headers = [
            'Authorization' => 'Bearer ' . $apiKey
        ];

        // set the organization
        if ($org) {
            $headers['OpenAI-Organization'] = $this->org;
        }

        $stack = HandlerStack::create();

        // retries
        if ($retryCount > 0) {
            $stack->push(GuzzleRetryMiddleware::factory([
                'retries' => $retryCount
            ]));
        }

        // create the client
        $this->guzzleClient = new Client([
            'base_uri' => 'https://api.openai.com/' . $this->apiVersion . '/',
            'headers' => $headers,
            'handler' => $stack,
        ]);
    }

    /**
     * Get the GuzzleHttp client instance.
     *
     * @return \GuzzleHttp\Client
     */
    public function getGuzzleClient(): Client
    {
        return $this->guzzleClient;
    }

    /**
     * List and describe the various models available in the API.
     * @see https://platform.openai.com/docs/api-reference/models
     */
    public function models(): Models
    {
        return new Models($this->getGuzzleClient());
    }

    /**
     * Given a list of messages comprising a conversation, the model will return a response.
     */
    public function chat(string $model = Models::GPT_TURBO, array $params = []): Chat
    {
        return new Chat($this->getGuzzleClient(), $model, $params);
    }

    /**
     * Given a prompt, the model will return one or more predicted completions, and can also return the probabilities of alternative tokens at each position.
     *
     * @deprecated Use chat() instead.
     */
    public function completions(string $model = Models::GPT_TURBO_INSTRUCT, array $params = []): Completions
    {
        return new Completions($this->getGuzzleClient(), $model, $params);
    }

    /**
     * Given a prompt and/or an input image, the model will generate a new image.
     */
    public function dalle(): DallE
    {
        return new DallE($this->getGuzzleClient());
    }

    /**
     * Get a vector representation of a given input that can be easily consumed by machine learning models and algorithms.
     */
    public function embeddings(string $model = Models::EMBEDDING, array $params = []): Embeddings
    {
        return new Embeddings($this->getGuzzleClient(), $model, $params);
    }

    /**
     * Manage files stored on OpenAI's servers.
     */
    public function files(): Files
    {
        return new Files($this->getGuzzleClient());
    }

    /**
     * Manage fine-tuning jobs to tailor a model to your specific training data.
     */
    public function finetunes(): FineTunes
    {
        return new FineTunes($this->getGuzzleClient());
    }

    /**
     * Given a input text, outputs if the model classifies it as violating OpenAI's content policy.
     */
    public function moderations(string $model = Models::MODERATION_LATEST, array $params = []): Moderations
    {
        return new Moderations($this->getGuzzleClient(), $model, $params);
    }

    /**
     * Turn audio into text.
     */
    public function whisper(string $model = Models::WHISPER): Whisper
    {
        return new Whisper($this->getGuzzleClient(), $model);
    }
}
