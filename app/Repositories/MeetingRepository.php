<?php

namespace App\Repositories;

use App\Interfaces\MeetingRepositoryInterface;
use App\Models\Meeting;

class MeetingRepository implements MeetingRepositoryInterface
{
    public function get($request)
    {
        $page = $request->page ?? 1;
        $perPage = $request->perPage ?? 10;
        $skip = ($page - 1) * $perPage;

        $meetings = Meeting::query();

        if ($request->topic) {
            $meetings = $meetings->where('topic', 'LIKE', '%' . $request->topic . '%');
        }

        $totalRecords = $this->count($meetings);
        $meetings = $meetings->latest()->skip($skip)->take($perPage)->get();

        return [
            'currentPage' => $page,
            'recordsPerPage' => $perPage,
            'meetings' => $meetings,
            'totalRecords' => $totalRecords
        ];
    }

    public function count($meetings)
    {
        return $meetings->count();
    }

    public function getById($id)
    {
        return Meeting::findOrFail($id);
    }

    public function getByKey($key)
    {
        return Meeting::where('key', $key)->firstOrFail();
    }

    public function getByIds($ids)
    {
        return Meeting::findOrFail($ids);
    }

    public function create($request)
    {
        return Meeting::create([
            'topic'      => $request->topic,
            'meeting_id' => $request->id,
            'join_url'   => $request->join_url,
            'start_url'   => $request->start_url,
            'start_time' => $request->start_time,
            'duration'   => $request->duration,
            'user_id'    => auth()->user()->id
        ]);
    }

    public function update($request, $key)
    {
        $meeting = $this->getByKey($key);

        $meeting->update([
            'topic'      => $request->topic,
            'start_time' => $request->start_time,
            'duration'   => $request->duration
        ]);

        return $meeting;
    }

    public function model()
    {
        return new Meeting();
    }
}
