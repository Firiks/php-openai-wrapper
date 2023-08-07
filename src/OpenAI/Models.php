<?php

namespace Firiks\PhpOpenaiWrapper\OpenAI;

use Firiks\PhpOpenaiWrapper\Http\Request;

class Models extends Request
{
    // list of models https://platform.openai.com/docs/guides/gpt
    public const GPT_TURBO = 'gpt-3.5-turbo';
    public const GPT_4 = 'gpt-4';
    public const EMBEDDING = 'text-embedding-ada-002';
    public const ADA = 'text-ada-001';
    public const DAVINCI = 'text-davinci-003';
    public const CURIE = 'text-curie-001';
    public const BABBAGE = 'text-babbage-001';
    public const MODERATION_STABLE = 'text-moderation-stable';
    public const MODERATION_LATEST = 'text-moderation-latest';
    public const WHISPER = 'whisper-1';

    /**
     * List all available models.
     *
     * @return object
     */
    public function listModels(): object
    {
        return $this->request('GET', 'models');
    }

    /**
     * Retrieve a specific model information.
     *
     * @param string $model
     *
     * @return object
     */
    public function retrieveModel(string $model): object
    {
        $model = \strtolower(\trim($model));
        return $this->request('GET', 'models/' . $model);
    }
}
