<?php

namespace Firiks\PhpOpenaiWrapper\OpenAI;

use Firiks\PhpOpenaiWrapper\Http\Request;
use GuzzleHttp\Psr7\Utils;

class Whisper extends Request
{
    protected string $model;

    public function __construct(\GuzzleHttp\Client $client, string $model)
    {
        parent::__construct($client);
        $this->model = $model;
    }

    /**
     * Transcribes audio into the input language.
     *
     * @param string $audio_path accepts mp3, mp4, mpeg, mpga, m4a, wav, or webm.
     * @param array $params
     *
     * @return object
     */
    public function createTranscription(string $audio_path, array $params = []): object
    {
        $contents = Utils::streamFor(fopen($audio_path, 'r'));
        $audio_filename = \basename($audio_path);
        $audio_mime = \mime_content_type($audio_path);

        $body = [
            'multipart' => [
                [
                    'name' => 'audio',
                    'filename' => $audio_filename,
                    'Mime-Type' => $audio_mime,
                    'contents' => $contents
                ],
                [
                    'name' => 'model',
                    'contents' => $this->model
                ],
            ]
        ];

        foreach ($params as $key => $value) {
            if (in_array($key, array_keys($body['multipart']))) {
                continue;
            }

            $body['multipart'][] = [
                'name' => $key,
                'contents' => $value
            ];
        }

        return $this->request('POST', 'audio/transcriptions', $body);
    }

    /**
     * Translates audio into English.
     *
     * @param string $audio_path accepts mp3, mp4, mpeg, mpga, m4a, wav, or webm.
     * @param array $params
     *
     * @return object
     */
    public function createTranslation(string $audio_path, array $params = []): object
    {
        $contents = Utils::streamFor(fopen($audio_path, 'r'));

        $body = [
            'multipart' => [
                [
                    'name' => 'audio',
                    'contents' => $contents
                ],
                [
                    'name' => 'model',
                    'contents' => $this->model
                ],
            ]
        ];

        foreach ($params as $key => $value) {
            if (in_array($key, array_keys($body['multipart']))) {
                continue;
            }

            $body['multipart'][] = [
                'name' => $key,
                'contents' => $value
            ];
        }

        return $this->request('POST', 'audio/translations', $body);
    }
}
