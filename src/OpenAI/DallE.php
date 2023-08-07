<?php

namespace Firiks\PhpOpenaiWrapper\OpenAI;

use GuzzleHttp\Psr7\Utils;
use Firiks\PhpOpenaiWrapper\Http\Request;

class DallE extends Request
{
    public function __construct(\GuzzleHttp\Client $client)
    {
        parent::__construct($client);
    }

    /**
     * Creates an image given a prompt.
     *
     * @param string $prompt
     * @param array $params
     *
     * @return object
     */
    public function createImage(string $prompt, array $params = []): object
    {
        $params['prompt'] = $prompt;

        $body = [
            'body' => \json_encode($params),
            'headers' => [
                'Content-Type' => 'application/json'
            ],
        ];

        return $this->request('POST', 'images/generations', $body);
    }

    /**
     * Creates an edited or extended image given an original image and a prompt. ( Need to use transparent png (RGBA - (RGB - alpha) ).
     *
     * @param string $prompt
     * @param string $image_path must be a valid PNG file, less than 4MB, and square. Must bu transparent if no mask is provided.
     * @param string $mask_path
     * @param array $params
     *
     * @return object
     * @see https://community.openai.com/t/how-can-i-provide-a-rgba-png-file-to-openai-php-library/22604
     */
    public function createImageEdit(string $prompt, string $image_path, string $mask_path = '', array $params = []): object
    {
        $contents_image = Utils::streamFor(fopen($image_path, 'r'));
        $image_filename = \basename($image_path);

        $body = [
            'multipart' => [
                [
                    'name' => 'image',
                    'filename' => $image_filename,
                    'Mime-Type' => 'image/png',
                    'contents' => $contents_image
                ],
                [
                    'name' => 'prompt',
                    'contents' => $prompt
                ],
            ]
        ];

        if ($mask_path) {
            $contents_mask = Utils::streamFor(fopen($mask_path, 'r'));

            $image_filename = \basename($mask_path);

            $body['multipart'][] = [
                'name' => 'mask',
                'filename' => $image_filename,
                'Mime-Type' => 'image/png',
                'contents' => $contents_mask
            ];
        }

        if (!empty($params)) {
            foreach ($params as $key => $value) {
                if (in_array($key, array_keys($body['multipart']))) {
                    continue;
                }

                $body['multipart'][] = [
                    'name' => $key,
                    'contents' => $value
                ];
            }
        }

        return $this->request('POST', 'images/edits', $body);
    }

    /**
     * Creates a variation of a given image. ( Need to use transparent png (RGBA - (RGB - alpha) ).
     *
     * @param string $image_path
     * @param array $params
     *
     * @return object
     */
    public function createImageVariation(string $image_path, $params = []): object
    {
        $contents_image = Utils::streamFor(fopen($image_path, 'r'));

        $body = [
            'multipart' => [
                [
                    'name' => 'image',
                    'contents' => $contents_image
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

        return $this->request('POST', 'images/variations', $body);
    }

}
