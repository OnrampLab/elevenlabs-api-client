<?php

namespace OnrampLab\ElevenlabsApiClient\Tests\Api\Resources;

use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Psr7\Response;
use OnrampLab\ElevenlabsApiClient\Api\Client;
use OnrampLab\ElevenlabsApiClient\Api\Resources\User;

class UserTest extends TestCase
{
    private MockInterface $httpClientMock;

    private Client $apiClient;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->httpClientMock = Mockery::mock(HttpClient::class);
        $this->apiClient = new Client(['apiToken' => 'test-api-key']);
        $this->apiClient->setHttpClient($this->httpClientMock);
        $this->user = new User($this->apiClient);
    }

    /**
     * @test
     */
    public function info_should_work()
    {
        $uri = $this->apiClient->getEndPoint('v1/user');
        $data = file_get_contents(__DIR__ . '/Data/User/get_user_info_success_response.json');

        $response = new Response(200, [], $data);

        $this->httpClientMock
            ->shouldReceive('request')
            ->once()
            ->withArgs(function (string $method, string $requestUri, array $requestOptions) use ($uri) {
                return $method === 'GET'
                    && $requestUri === $uri
                    && $requestOptions['headers']['Accept'] === 'application/json'
                    && $requestOptions['headers']['xi-api-key'] === 'test-api-key';
            })
            ->andReturn($response);

        $result = $this->user->info();

        $this->assertIsArray($result);
    }

    /**
     * @test
     */
    public function subscription_info_should_work()
    {
        $uri = $this->apiClient->getEndPoint('v1/user/subscription');
        $data = file_get_contents(__DIR__ . '/Data/User/get_user_info_success_response.json');

        $response = new Response(200, [], $data);

        $this->httpClientMock
            ->shouldReceive('request')
            ->once()
            ->withArgs(function (string $method, string $requestUri, array $requestOptions) use ($uri) {
                return $method === 'GET'
                    && $requestUri === $uri
                    && $requestOptions['headers']['Accept'] === 'application/json'
                    && $requestOptions['headers']['xi-api-key'] === 'test-api-key';
            })
            ->andReturn($response);

        $result = $this->user->subscriptionInfo();

        $this->assertIsArray($result);
    }
}
