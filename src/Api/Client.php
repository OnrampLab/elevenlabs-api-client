<?php

namespace OnrampLab\ElevenlabsApiClient\Api;

use OnrampLab\ApiClient\Api\Client as ApiClient;
use OnrampLab\ElevenlabsApiClient\Api\Resources\SampleResource;

class Client extends ApiClient
{
    public SampleResource $sampleResource;

    public function __construct($config)
    {
        $config['baseUrl'] = 'https://www.example.com';
        parent::__construct($config);

        $this->sampleResource = new SampleResource($this);
    }
}
