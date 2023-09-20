<?php

namespace OnrampLab\PhpApiClientTemplate\Tests\Api\Resources;

use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Psr7\Response;
use OnrampLab\PhpApiClientTemplate\Api\Client;
use OnrampLab\PhpApiClientTemplate\Api\Resources\SampleResource;

class SampleResourceTest extends TestCase
{
    private MockInterface $httpClientMock;

    private Client $apiClient;

    private SampleResource $sampleResource;

    protected function setUp(): void
    {
        parent::setUp();

        $this->httpClientMock = Mockery::mock(HttpClient::class);
        $this->apiClient = new Client(['apiToken' => 'fake_token']);
        $this->apiClient->setHttpClient($this->httpClientMock);
        $this->sampleResource = new SampleResource($this->apiClient);
    }

    /**
     * @test
     */
    public function list_should_work()
    {
        $uri = $this->apiClient->getEndPoint('sample');
        $data = [
            'data' => [
                ['fake_key' => 'fake_value'],
            ],
        ];
        $response = new Response(200, [], json_encode($data));

        $this->httpClientMock
            ->shouldReceive('request')
            ->once()
            ->withArgs(function (string $method, string $requestUri, array $requestOptions) use ($uri) {
                return $method === 'GET'
                    && $requestUri === $uri;
            })
            ->andReturn($response);

        $result = $this->sampleResource->list();

        $this->assertIsArray($result['data'][0]);
    }
}
