<?php

namespace App\Services;

use App\Interfaces\MeetingRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class MeetingService
{
    private MeetingRepositoryInterface $meetingRepository;
    private ZoomService $zoomService;

    public function __construct(MeetingRepositoryInterface $meetingRepository, ZoomService $zoomService)
    {
        $this->meetingRepository = $meetingRepository;
        $this->zoomService = $zoomService;
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
                $zoom = $this->zoomService->createMeeting($request->topic, $request->startTime, $request->duration);
                $this->meetingRepository->create($zoom);
            });

            return true;
        } catch (Exception $e) {
            dd($e);
            return false;
        }
    }

    public function updateMeeting($request, $key)
    {
        return $this->meetingRepository->update($request, $key);
    }
}
