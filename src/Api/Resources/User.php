<?php

namespace OnrampLab\ElevenlabsApiClient\Api\Resources;

use OnrampLab\ElevenlabsApiClient\Api\Client;

class User
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function info(): array
    {
        $resource = 'v1/user';
        $url = $this->client->getEndPoint($resource);

        $response = $this->client->request('GET', $url);

        return json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
    }

    public function subscriptionInfo(): array
    {
        $resource = 'v1/user/subscription';
        $url = $this->client->getEndPoint($resource);

        $response = $this->client->request('GET', $url);

        return json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
    }
}
