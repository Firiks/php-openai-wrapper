# OpenAI PHP wrapper

This is a PHP wrapper for the [OpenAI API](https://beta.openai.com/docs/api-reference/introduction).

## Exampe usage

```php
<?php

require_once 'vendor/autoload.php';

$wrapper = new \Firiks\PhpOpenaiWrapper\PhpOpenaiWrapper( 'YOUR-API-KEY' );

try {
    // Models
    $models = $wrapper->models();
    $model_list = $models->listModels();
    $model_info = $models->retrieveModel('gpt-3.5-turbo');

    // Chat
    $chat_response = $wrapper->chat()->createChatCompletition( [['role' => 'system', 'content' => 'You are a helpful assistant.'], ['role' => 'user', 'content' => 'Hello, who are you?']] );

    // Moderation
    $moderation_response = $wrapper->moderations()->createTextModeration( 'I want to kill them.');

    // Embeddings
    $embedding_response = $wrapper->embeddings()->createEmbeddings( 'The food was delicious and the waiter...' );

    // DaLL-E
    $dallE = $wrapper->dalle();
    $new_image = $dallE->createImage('A painting of a capybara sitting in a field at night', ['size' => '1024x1024', 'n' => 1]);
    $image_edit = $dallE->createImageEdit('A painting of a capybara sitting near lake at day', __DIR__ . '/tmp/capybara.png', '', ['size' => '1024x1024', 'n' => 2]);
    $image_variation = $dallE->createImageVariation(__DIR__ . '/tmp/capybara.png', ['size' => '1024x1024', 'n' => 2]);

    // Whisper
    $whisper = $wrapper->whisper();
    $transcription = $whisper->createTranscription('./tmp/audio.wav');
    $translation = $whisper->createTranslation('./tmp/audio.wav');

    // Files
    $files = $wrapper->files();
    $files_list = $files->listFiles();
    $upload = $files->uploadFile('./tmp/data.json', 'training-data');
    $file_info = $files->retrieveFile($upload['id']);
    $file = $files->retrieveFileContents($upload['id']);
    $delete = $files->deleteFile($upload['id']);
} catch ( Exception $e ) {
    echo '<pre>';
    var_dump($e->getMessage());
    echo '</pre>';
}
```
