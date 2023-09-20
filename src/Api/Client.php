<?php

namespace OnrampLab\PhpApiClientTemplate\Api;

use OnrampLab\ApiClient\Api\Client as ApiClient;
use OnrampLab\PhpApiClientTemplate\Api\Resources\SampleResource;

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
