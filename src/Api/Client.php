<?php

namespace OnrampLab\ElevenlabsApiClient\Api;

use OnrampLab\ApiClient\Api\Client as ApiClient;
use OnrampLab\ElevenlabsApiClient\Api\Resources\TextToSpeech;
use OnrampLab\ElevenlabsApiClient\Api\Resources\User;
use Psr\Http\Message\ResponseInterface;

class Client extends ApiClient
{
    protected User $user;
    protected TextToSpeech $textToSpeech;

    public function __construct($config)
    {
        $config['baseUrl'] = 'https://api.elevenlabs.io';

        parent::__construct($config);

        $this->user = new User($this);
        $this->textToSpeech = new TextToSpeech($this);
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
