<?php

namespace OnrampLab\PhpApiClientTemplate\Api\Resources;

use OnrampLab\PhpApiClientTemplate\Api\Client;

/**
 * A sample resource
 *
 * Use this section to define what this resource is doing, the PhpDocumentor will use this
 * to automatically generate the API documentation
 *
 * @author Onramplab
 * @package Onramplab\PhpApiClientTemplate
 */
class SampleResource
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Sample method
     *
     * Always create a corresponding DocBlock for each method, describing what it is for,
     * this helps the PhpDocumentor to properly generate the documentation
     */
    public function list(): array
    {
        $resource = 'sample';
        $url = $this->client->getEndPoint($resource);

        $response = $this->client->request('GET', $url);
        $result = json_decode($response->getBody()->getContents(), true);

        return $result;
    }
}
