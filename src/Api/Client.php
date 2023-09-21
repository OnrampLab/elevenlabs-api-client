<?php

namespace OnrampLab\ElevenlabsApiClient\Api;

use OnrampLab\ApiClient\Api\Client as ApiClient;

class Client extends ApiClient
{

    public function __construct($config)
    {
        $config['baseUrl'] = 'https://www.example.com';
        parent::__construct($config);

    }
}
