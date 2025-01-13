<?php

namespace App\Traits;

use App\Models\ZoomToken;
use GuzzleHttp\Client;

trait ZoomTrait
{
    protected function getAccessToken()
    {
        $zoomToken = ZoomToken::where('user_id', auth()->user()->id)->first();

        // Refresh token if expired
        if ($zoomToken->access_token_expiry?->isPast()) {
            $this->refreshZoomToken();
            $zoomToken = ZoomToken::where('user_id', auth()->user()->id)->first();
        }

        return $zoomToken->access_token;
    }

    // Zoom authorization
    public function authorizeZoom()
    {
        return "https://zoom.us/oauth/authorize?response_type=code&client_id=" . env('ZOOM_CLIENT_ID') . "&redirect_uri=" . urlencode(env('ZOOM_REDIRECT_URI'));
    }

    // Handle callback
    public function handleCallback($code)
    {
        if (!$code) {
            return false;
        }

        $client = new Client();

        try {
            $response = $client->post('https://zoom.us/oauth/token', [
                'form_params' => [
                    'grant_type' => 'authorization_code',
                    'code' => $code,
                    'redirect_uri' => env('ZOOM_REDIRECT_URI'),
                ],
                'headers' => [
                    'Authorization' => 'Basic ' . base64_encode(env('ZOOM_CLIENT_ID') . ':' . env('ZOOM_CLIENT_SECRET')),
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            $expiresAt = now()->addSeconds($data['expires_in']);

            // Save the token
            ZoomToken::updateOrCreate(
                ['user_id' => auth()->user()->id],
                [
                    'access_token' => $data['access_token'],
                    'refresh_token' => $data['refresh_token'],
                    'access_token_expiry' => $expiresAt
                ]
            );

            return $data;
        } catch (\Exception $e) {
            return false;
        }
    }

    // Refresh the Zoom token
    public function refreshZoomToken()
    {
        $zoomToken = ZoomToken::where('user_id', auth()->user()->id)->first();
        $refreshToken = $zoomToken->refresh_token;

        if (!$refreshToken) {
            return false;
        }

        $client = new Client();

        try {
            $response = $client->post('https://zoom.us/oauth/token', [
                'form_params' => [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $refreshToken,
                ],
                'headers' => [
                    'Authorization' => 'Basic ' . base64_encode(env('ZOOM_CLIENT_ID') . ':' . env('ZOOM_CLIENT_SECRET')),
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            $expiresAt = now()->addSeconds($data['expires_in']);

            // Update token
            $zoomToken->update([
                'access_token' => $data['access_token'],
                'refresh_token' => $data['refresh_token'],
                'access_token_expiry' => $expiresAt
            ]);

            return $data;
        } catch (\Exception $e) {
            $zoomToken->delete();
            return false;
        }
    }

    // Create a Zoom meeting
    public function createZoomMeeting($topic, $startTime, $duration = 60, $password, $users, $timezone = 'UTC')
    {
        $accessToken = $this->getAccessToken();
        $client = new Client();

        try {
            $response = $client->post('https://api.zoom.us/v2/users/me/meetings', [
                'json' => [
                    'topic' => $topic,
                    'type' => 2, // Scheduled meeting
                    'start_time' => date('Y-m-d\TH:i:s', strtotime($startTime)),
                    'duration' => $duration,
                    'timezone' => $timezone,
                    'password' => $password,
                    'settings' => [
                        'join_before_host' => true,
                        'host_video' => false,
                        'participant_video' => false,
                        'mute_upon_entry' => true,
                        'waiting_room' => true,
                        'approval_type' => 1,
                        'registrants_email_notification' => true,
                        'meeting_authentication' => true,
                    ],
                ],
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                ],
            ]);

            $meeting = json_decode($response->getBody(), true);

            foreach ($users as $user) {
                $this->addRegistrantToMeeting($meeting['id'], $user);
            }

            return $meeting;
        } catch (\Exception $e) {
            return false;
        }
    }

    // Update a Zoom meeting
    public function updateZoomMeeting($meetingId, $topic, $startTime, $duration = 60, $password, $users, $timezone = 'UTC')
    {
        $accessToken = $this->getAccessToken();
        $client = new Client();

        try {
            $response = $client->patch("https://api.zoom.us/v2/meetings/{$meetingId}", [
                'json' => [
                    'topic' => $topic,
                    'type' => 2, // Scheduled meeting
                    'start_time' => date('Y-m-d\TH:i:s', strtotime($startTime)),
                    'duration' => $duration,
                    'timezone' => $timezone,
                    'password' => $password,
                    'settings' => [
                        'join_before_host' => true,
                        'host_video' => false,
                        'participant_video' => false,
                        'mute_upon_entry' => true,
                        'waiting_room' => true,
                        'approval_type' => 1,
                        'registrants_email_notification' => true,
                        'meeting_authentication' => true,
                    ],
                ],
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                ],
            ]);

            foreach ($users as $user) {
                $this->addRegistrantToMeeting($meetingId, $user);
            }
            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            return false;
        }
    }

    // Delete a Zoom meeting
    public function deleteZoomMeeting($meetingId)
    {
        $accessToken = $this->getAccessToken();
        $client = new Client();

        try {
            $client->delete("https://api.zoom.us/v2/meetings/{$meetingId}", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                ],
            ]);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function addRegistrantToMeeting($meetingId, $user)
    {
        $accessToken = $this->getAccessToken();
        $client = new Client();

        try {
            // Register the participant with their name and email
            $response = $client->post("https://api.zoom.us/v2/meetings/{$meetingId}/registrants", [
                'json' => [
                    'email' => $user->email,
                    'first_name' => $user->name,
                ],
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                ],
            ]);

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            return false;
        }
    }
}
