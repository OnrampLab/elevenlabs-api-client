<?php

namespace OnrampLab\ElevenlabsApiClient\Tests\Api\Resources;

use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Psr7\Response;
use OnrampLab\ElevenlabsApiClient\Api\Client;
use OnrampLab\ElevenlabsApiClient\Api\Resources\Voices;

class VoicesTest extends TestCase
{
    private MockInterface $httpClientMock;

    private Client $apiClient;

    private Voices $voices;

    private string $voiceId;

    protected function setUp(): void
    {
        parent::setUp();

        $this->httpClientMock = Mockery::mock(HttpClient::class);
        $this->apiClient = new Client(['apiToken' => 'test-api-key']);
        $this->apiClient->setHttpClient($this->httpClientMock);
        $this->voices = new Voices($this->apiClient);

        $this->voiceId = 'testVoiceId';
    }

    /**
     * @test
     */
    public function list_should_work()
    {
        $uri = $this->apiClient->getEndPoint('v1/voices');
        $data = file_get_contents(__DIR__ . '/Data/Voices/get_list_success_response.json');

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

        $result = $this->voices->list();

        $this->assertIsArray($result);
    }

    /**
     * @test
     */
    public function default_settings_should_work()
    {
        $uri = $this->apiClient->getEndPoint('v1/voices/settings/default');
        $data = file_get_contents(__DIR__ . '/Data/Voices/get_default_setting_success_response.json');

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

        $result = $this->voices->defaultSettings();

        $this->assertIsArray($result);
    }

    /**
     * @test
     */
    public function settings_should_work()
    {
        $uri = $this->apiClient->getEndPoint("v1/voices/{$this->voiceId}/settings");
        $data = file_get_contents(__DIR__ . '/Data/Voices/get_setting_success_response.json');

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

        $result = $this->voices->settings($this->voiceId);

        $this->assertIsArray($result);
    }

    /**
     * @test
     */
    public function edit_settings_should_work()
    {
        $uri = $this->apiClient->getEndPoint("v1/voices/{$this->voiceId}/settings/edit");
        $data = file_get_contents(__DIR__ . '/Data/Voices/edit_setting_success_response copy.json');

        $response = new Response(200, [], $data);

        $this->httpClientMock
            ->shouldReceive('request')
            ->once()
            ->withArgs(function (string $method, string $requestUri, array $requestOptions) use ($uri) {
                return $method === 'POST'
                    && $requestUri === $uri
                    && $requestOptions['headers']['Accept'] === 'application/json'
                    && $requestOptions['headers']['xi-api-key'] === 'test-api-key';
            })
            ->andReturn($response);

        $result = $this->voices->editSettings($this->voiceId, ['voices_stability' => 0.5, 'voices_similarity' => 0.75]);

        $this->assertIsArray($result);
    }

    /**
     * @test
     */
    public function get_should_work()
    {
        $uri = $this->apiClient->getEndPoint("v1/voices/{$this->voiceId}");
        $data = file_get_contents(__DIR__ . '/Data/Voices/get_voices_success_response.json');

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

        $result = $this->voices->get($this->voiceId);

        $this->assertIsArray($result);
    }
}
