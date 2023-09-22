<?php

namespace OnrampLab\ElevenLabsApiClient\Tests\Api\Resources;

use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Psr7\Response;
use OnrampLab\ElevenLabsApiClient\Api\Client;
use OnrampLab\ElevenLabsApiClient\Api\Resources\TextToSpeech;

class TextToSpeechTest extends TestCase
{
    private MockInterface $httpClientMock;

    private Client $apiClient;

    private TextToSpeech $textToSpeech;

    protected function setUp(): void
    {
        parent::setUp();

        $this->httpClientMock = Mockery::mock(HttpClient::class);
        $this->apiClient = new Client(['apiToken' => 'test-api-key']);
        $this->apiClient->setHttpClient($this->httpClientMock);
        $this->textToSpeech = new TextToSpeech($this->apiClient);
    }

    /**
     * @test
     */
    public function create_audio_should_work()
    {
        $speechInfo = [
            'voices_id' => 'testVoicesId',
            'text' => 'develop test',
            'model_id' => 'eleven_multilingual_v1',
            'voices_stability' => 0.5,
            'voices_similarity' => 0.5,
        ];

        $uri = $this->apiClient->getEndPoint("v1/text-to-speech/{$speechInfo['voices_id']}");
        $data = file_get_contents(__DIR__ . '/Data/TextToSpeech/get_text_to_speech.mp3');

        $response = new Response(200, [], $data);

        $this->httpClientMock
            ->shouldReceive('request')
            ->once()
            ->withArgs(function (string $method, string $requestUri, array $requestOptions) use ($uri) {
                return $method === 'POST'
                    && $requestUri === $uri
                    && $requestOptions['headers']['Accept'] === 'audio/mpeg'
                    && $requestOptions['headers']['xi-api-key'] === 'test-api-key';
            })
            ->andReturn($response);

        $result = $this->textToSpeech->createAudio($speechInfo);

        $this->assertIsString($result);
    }

    /**
     * @test
     */
    public function create_stream_audio_should_work()
    {
        $speechInfo = [
            'voices_id' => 'testVoicesId',
            'text' => 'develop test',
            'model_id' => 'eleven_multilingual_v1',
            'voices_stability' => 0.5,
            'voices_similarity' => 0.5,
        ];

        $uri = $this->apiClient->getEndPoint("v1/text-to-speech/{$speechInfo['voices_id']}");
        $data = file_get_contents(__DIR__ . '/Data/TextToSpeech/get_stream_text_to_speech.mp3');

        $response = new Response(200, [], $data);

        $this->httpClientMock
            ->shouldReceive('request')
            ->once()
            ->withArgs(function (string $method, string $requestUri, array $requestOptions) use ($uri) {
                return $method === 'POST'
                    && $requestUri === $uri
                    && $requestOptions['headers']['Accept'] === 'audio/mpeg'
                    && $requestOptions['headers']['xi-api-key'] === 'test-api-key';
            })
            ->andReturn($response);

        $result = $this->textToSpeech->createAudio($speechInfo);

        $this->assertIsString($result);
    }
}
