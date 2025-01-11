<?php

namespace App\Traits;

use Jubaer\Zoom\Facades\Zoom;

trait ZoomTrait
{
    public function createZoomMeeting($topic, $startTime, $duration = 60, $password, $timezone = 'UTC')
    {
        return Zoom::createMeeting([
            "topic" => $topic,
            "type" => 2, // 1 => instant, 2 => scheduled, 3 => recurring with no fixed time, 8 => recurring with fixed time
            "duration" => $duration,
            "timezone" => $timezone,
            "password" => $password,
            "start_time" => date('Y-m-d\TH:i:s', strtotime($startTime)),
            "settings" => [
                'join_before_host' => true,
                'host_video' => false,
                'participant_video' => false,
                'mute_upon_entry' => false,
                'waiting_room' => false,
                'approval_type' => 1,
            ],
        ]);
    }

    public function updateZoomMeeting($meetingId, $topic, $startTime, $duration = 60, $password, $timezone = 'UTC')
    {
        return Zoom::updateMeeting($meetingId, [
            "topic" => $topic,
            "type" => 2, // 1 => instant, 2 => scheduled, 3 => recurring with no fixed time, 8 => recurring with fixed time
            "duration" => $duration,
            "timezone" => $timezone,
            "password" => $password,
            "start_time" => date('Y-m-d\TH:i:s', strtotime($startTime)),
            "settings" => [
                'join_before_host' => true,
                'host_video' => false,
                'participant_video' => false,
                'mute_upon_entry' => false,
                'waiting_room' => false,
                'approval_type' => 1,
            ],
        ]);
    }
}
