<?php

namespace App\Http\Controllers;

use App\Http\Requests\Meeting\CreateMeetingRequest;
use App\Http\Requests\Meeting\UpdateMeetingRequest;
use App\Services\MeetingService;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    private MeetingService $meetingService;

    public function __construct(MeetingService $meetingService)
    {
        $this->meetingService = $meetingService;
    }

    public function index(Request $request)
    {
        $result = (object) $this->meetingService->getMeetings($request);
        return view('modules.meeting.index', compact('result'));        
    }

    public function create()
    {
        return view('modules.meeting.create');
    }

    public function store(CreateMeetingRequest $request)
    {
        if($this->meetingService->createMeeting($request)) {
            return redirect()->route('meeting.index')->with('success', 'Meeting is created.');
        }
        return redirect()->route('meeting.index')->with('error', 'Meeting is not created.');
    }

    public function edit($key)
    {
        $meeting = $this->meetingService->getMeetingByKey($key);
        return view('modules.meeting.edit', compact('meeting'));
    }

    public function update(UpdateMeetingRequest $request, $key)
    {
        if($this->meetingService->updateMeeting($request, $key)) {
            return redirect()->route('meeting.index')->with('success', 'Meeting is updated.');
        }
        return redirect()->route('meeting.index')->with('error', 'Meeting is not updated.');
    }

    public function delete(Request $request)
    {
        if($this->meetingService->deleteMeeting($request->key)) {
            return redirect()->route('meeting.index')->with('success', 'Meeting is updated.');
        }
        return redirect()->route('meeting.index')->with('error', 'Meeting is not updated.');
    }
}
