<?php

namespace OnrampLab\ElevenlabsApiClient\Api\Resources;

use OnrampLab\ElevenlabsApiClient\Api\Client;

class Voices
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function list(): array
    {
        $resource = 'v1/voices';
        $url = $this->client->getEndPoint($resource);

        $response = $this->client->request('GET', $url);

        return json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
    }

    public function defaultSettings(): array
    {
        $resource = 'v1/voices/settings/default';
        $url = $this->client->getEndPoint($resource);

        $response = $this->client->request('GET', $url);

        return json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
    }

    public function settings(string $voiceId): array
    {
        $resource = "v1/voices/{$voiceId}/settings";
        $url = $this->client->getEndPoint($resource);

        $response = $this->client->request('GET', $url);

        return json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
    }

    public function editSettings(string $voiceId, array $voiceSetting = []): array
    {
        $resource = "v1/voices/{$voiceId}/settings/edit";
        $url = $this->client->getEndPoint($resource);

        $payload = [
            'stability' => $voiceSetting['voices_stability'],
            'similarity_boost' => $voiceSetting['voices_similarity'],
            'style' => $voiceSetting['voices_style'] ?? 0,
            'use_speaker_boost' => $voiceSetting['voices_use_speaker'] ?? true,
        ];

        $response = $this->client->request('POST', $url, [], $payload);

        return json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
    }

    public function get(string $voiceId): array
    {
        $resource = "v1/voices/{$voiceId}";
        $url = $this->client->getEndPoint($resource);

        $response = $this->client->request('GET', $url);

        return json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
    }

    public function add(): void
    {
        // Add a new voice to your collection of voices in VoiceLab.
        $resource = 'v1/voices/add';
        $url = $this->client->getEndPoint($resource);
    }

    public function edit(string $voiceId): void
    {
        // Edit a voice created by you.
        $resource = "v1/voices/{$voiceId}/edit";
        $url = $this->client->getEndPoint($resource);
    }

    public function delete(string $voiceId): void
    {
        // Deletes a voice by its ID.
        $resource = "v1/voices/{$voiceId}";
        $url = $this->client->getEndPoint($resource);
    }
}
