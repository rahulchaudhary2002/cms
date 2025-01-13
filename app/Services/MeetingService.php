<?php

namespace App\Services;

use App\Interfaces\MeetingRepositoryInterface;
use App\Traits\ZoomTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MeetingService
{
    use ZoomTrait;

    private MeetingRepositoryInterface $meetingRepository;

    public function __construct(MeetingRepositoryInterface $meetingRepository)
    {
        $this->meetingRepository = $meetingRepository;
    }

    public function getMeetings($request)
    {
        return $this->meetingRepository->get($request);
    }

    public function getMeetingByKey($key)
    {
        return $this->meetingRepository->getByKey($key);
    }

    public function createMeeting($request)
    {
        try {
            DB::transaction(function () use ($request) {
                $uesrs = (object) [
                    (object) [
                        'name' => "Rahul Chaudhary",
                        'email' => 'rahulccaudhary@gmail.com'
                    ],
                    (object) [
                        'name' => "Test1",      
                        'email' => 'test1@app.com'
                    ]
                ];

                $zoom = $this->createZoomMeeting($request->topic, $request->startTime, $request->duration, Str::random(6), $uesrs);

                $request['id'] = $zoom['id'];
                $request['start_url'] = $zoom['start_url'];
                $request['join_url'] = $zoom['join_url'];

                $this->meetingRepository->create($request);
            });

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function updateMeeting($request, $key)
    {
        try {
            DB::transaction(function () use ($request, $key) {
                $uesrs = (object) [
                    (object) [
                        'name' => "Test",
                        'email' => 'test@app.com'
                    ]
                ];

                $meeting = $this->getMeetingByKey($key);
                $this->updateZoomMeeting($meeting->meeting_id, $request->topic, $request->startTime, $request->duration, Str::random(6), $uesrs);
                $this->meetingRepository->update($request, $key);
            });

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function deleteMeeting($key)
    {
        try {
            DB::transaction(function () use ($key) {
                $meeting = $this->getMeetingByKey($key);
                $this->deleteZoomMeeting($meeting->meeting_id);
                $meeting->delete();
            });

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
