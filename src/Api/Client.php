<?php

namespace OnrampLab\ElevenlabsApiClient\Api;

use OnrampLab\ApiClient\Api\Client as ApiClient;

class Client extends ApiClient
{

    public function __construct($config)
    {
        $config['baseUrl'] = 'https://api.elevenlabs.io';

        parent::__construct($config);

    }

    public function applyAuth(array $payload): array
    {
        $payload['headers']['xi-api-key'] = $this->apiToken;

        return $payload;
    }
}
