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
                $zoom = $this->createZoomMeeting($request->topic, $request->startTime, $request->duration, Str::random(6));

                $request['id'] = $zoom['data']['id'];
                $request['start_url'] = $zoom['data']['start_url'];
                $request['join_url'] = $zoom['data']['join_url'];

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
                $meeting = $this->getMeetingByKey($key);
                $this->updateZoomMeeting($meeting->meeting_id, $request->topic, $request->startTime, $request->duration, Str::random(6));
                $this->meetingRepository->update($request, $key);
            });

            return true;
        } catch (Exception $e) {
            dd($e);
            return false;
        }
    }
}
