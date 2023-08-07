<?php

namespace Firiks\PhpOpenaiWrapper\OpenAI;

use Firiks\PhpOpenaiWrapper\Http\Request;

class FineTunes extends Request
{
    public function __construct(\GuzzleHttp\Client $client)
    {
        parent::__construct($client);
    }

    /**
     * Creates a job that fine-tunes a specified model from a given dataset.
     *
     * @param string $training_file The ID of an uploaded file that contains training data.
     * @param array $params
     *
     * @return void
     */
    public function createFineTune(string $training_file, array $params = [])
    {
        $params['training_file'] = $training_file;
        return $this->request('POST', 'fine-tunes', $params);
    }

    /**
     * List your organization's fine-tuning jobs.
     *
     * @return object
     */
    public function listFineTunes(): object
    {
        return $this->request('GET', 'fine-tunes');
    }

    /**
     * Gets info about the fine-tune job.
     *
     * @param string $id
     *
     * @return object
     */
    public function retrieveFineTune(string $id): object
    {
        return $this->request('GET', 'fine-tunes/' . $id);
    }

    /**
     * Immediately cancel a fine-tune job.
     *
     * @param string $id
     *
     * @return object
     */
    public function cancelFineTune(string $id): object
    {
        return $this->request('POST', 'fine-tunes/' . $id . '/cancel');
    }

    /**
     * Get fine-grained status updates for a fine-tune job.
     *
     * @param string $id
     *
     * @return object
     */
    public function listFinetuneEvents(string $id): object
    {
        return $this->request('GET', 'fine-tunes/' . $id . '/events');
    }

    /**
     * Delete a fine-tuned model. You must have the Owner role in your organization.
     *
     * @param string $id
     *
     * @return object
     */
    public function deleteFineTuneModel(string $model): object
    {
        return $this->request('DELETE', 'models/' . $model);
    }
}
