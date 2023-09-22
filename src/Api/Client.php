<?php

namespace OnrampLab\ElevenLabsApiClient\Api;

use OnrampLab\ApiClient\Api\Client as ApiClient;
use OnrampLab\ElevenLabsApiClient\Api\Resources\TextToSpeech;
use OnrampLab\ElevenLabsApiClient\Api\Resources\User;
use OnrampLab\ElevenLabsApiClient\Api\Resources\Voices;
use Psr\Http\Message\ResponseInterface;

class Client extends ApiClient
{
    protected User $user;
    protected TextToSpeech $textToSpeech;
    protected Voices $voices;

    public function __construct($config)
    {
        $config['baseUrl'] = 'https://api.elevenlabs.io';

        parent::__construct($config);

        $this->user = new User($this);
        $this->textToSpeech = new TextToSpeech($this);
        $this->voices = new Voices($this);
    }

    public function applyAuth(array $payload): array
    {
        $payload['headers']['xi-api-key'] = $this->apiToken;

        return $payload;
    }

    public function request(string $method, string $url, array $params = [], array $data = []): ResponseInterface
    {
        $accept = strpos($url, 'https://api.elevenlabs.io/v1/text-to-speech') === 0 ? 'audio/mpeg' : 'application/json';

        $payload = $this->applyMiddlewares([
            'query' => $params,
            'json' => (object) $data,
            'headers' => [
                'Accept' => $accept,
            ],
        ]);

        return $this->httpClient->request($method, $url, $payload);
    }
}
