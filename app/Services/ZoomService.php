<?php

namespace App\Services;

use Firebase\JWT\JWT;
use GuzzleHttp\Client;

class ZoomService
{
    private $client;
    private $jwtToken;
    private $apiBaseUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->jwtToken = $this->generateJwtToken();
        $this->apiBaseUrl = 'https://api.zoom.us/v2/';
    }

    private function generateJwtToken()
    {
        $payload = [
            'iss' => env('ZOOM_API_KEY'),
            'exp' => now()->addMinutes(60)->timestamp,
            'account_id' => env('ZOOM_ACCOUNT_ID'),
        ];

        return JWT::encode($payload, env('ZOOM_API_SECRET'), 'HS256');
    }

    public function createMeeting($topic, $startTime, $duration = 60, $timezone = 'UTC')
    {
        $url = $this->apiBaseUrl . 'users/me/meetings';
        
        $response = $this->client->post($url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->jwtToken,
                'Content-Type'  => 'application/json',
            ],
            'json' => [
                'topic'      => $topic,
                'type'       => 2,
                'start_time' => $startTime,
                'duration'   => $duration,
                'timezone'   => $timezone,
                'settings'   => [
                    'host_video'        => true,
                    'participant_video' => true,
                    'waiting_room'      => true,
                ],
            ],
        ]);

        if ($response->getStatusCode() == 201) {
            return json_decode($response->getBody()->getContents(), true);
        }

        return null;
    }
}
