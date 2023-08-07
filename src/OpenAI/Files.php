<?php

namespace Firiks\PhpOpenaiWrapper\OpenAI;

use GuzzleHttp\Psr7\Utils;
use Firiks\PhpOpenaiWrapper\Http\Request;

class Files extends Request
{
    public function __construct(\GuzzleHttp\Client $client)
    {
        parent::__construct($client);
    }

    /**
     * Returns a list of files that belong to the user's organization.
     *
     * @return object
     */
    public function listFiles(): object
    {
        return $this->request('GET', 'files');
    }

    /**
     * Upload a file that contains document(s) to be used across various endpoints/features. Currently, the size of all the files uploaded by one organization can be up to 1 GB. Please contact us if you need to increase the storage limit.
     *
     * @param string $file_path
     * @param string $purpose
     *
     * @return object
     */
    public function uploadFile(string $file_path, string $purpose): object
    {

        $filename = basename($file_path);

        $contents = Utils::streamFor(fopen($file_path, 'r'));

        $body = [
            'multipart' => [
                [
                    'name' => 'purpose',
                    'contents' => $purpose
                ],
                [
                    'name' => 'file',
                    'filename' => $filename,
                    'contents' => $contents
                ]
            ]
        ];

        return $this->request('POST', 'files', $body);
    }

    /**
     * Delete a file.
     *
     * @param string $id
     *
     * @return object
     */
    public function deleteFile(string $id): object
    {
        return $this->request('DELETE', 'files/' . $id);
    }

    /**
     * Returns information about a specific file.
     *
     * @param string $id
     *
     * @return object
     */
    public function retrieveFile(string $id): object
    {
        return $this->request('GET', 'files/' . $id);
    }

    /**
     * Returns the contents of the specified file
     *
     * @param string $id
     *
     * @return object
     */
    public function retrieveFileContents(string $id): object
    {
        return $this->request('GET', 'files/' . $id . '/content', [], false);
    }
}
