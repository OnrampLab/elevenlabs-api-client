<?php

namespace OnrampLab\ElevenlabsApiClient\Api\Resources;

use OnrampLab\ElevenlabsApiClient\Api\Client;

class TextToSpeech
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function createAudio(array $speechInfo): string
    {
        $resource = "v1/text-to-speech/{$speechInfo['voices_id']}";
        $url = $this->client->getEndPoint($resource);

        $payload = [
            'text' => $speechInfo['text'],
            'model_id' => $speechInfo['model_id'],
            'voice_settings' => [
                'stability' => $speechInfo['voices_stability'],
                'similarity_boost' => $speechInfo['voices_similarity'],
                'style' => $speechInfo['voices_style'] ?? 0,
                'use_speaker_boost' => $speechInfo['voices_use_speaker'] ?? true,
            ],
        ];

        $response = $this->client->request('POST', $url, [], $payload);

        return $response->getBody()->getContents();
    }

    public function createStreamAudio(array $speechInfo): string
    {
        $resource = "v1/text-to-speech/{$speechInfo['voices_id']}/stream";
        $url = $this->client->getEndPoint($resource);

        $payload = [
            'text' => $speechInfo['text'],
            'model_id' => $speechInfo['model_id'],
            'voice_settings' => [
                'stability' => $speechInfo['voices_stability'],
                'similarity_boost' => $speechInfo['voices_similarity'],
                'style' => $speechInfo['voices_style'] ?? 0,
                'use_speaker_boost' => $speechInfo['voices_use_speaker'] ?? true,
            ],
        ];

        $response = $this->client->request('POST', $url, [], $payload);

        return $response->getBody()->getContents();
    }
}
