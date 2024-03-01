<?php

namespace App\Http\Controllers;

use App\Http\Requests\University\CreateUniversityRequest;
use App\Http\Requests\University\UpdateUniversityRequest;
use App\Services\UniversityService;
use Illuminate\Http\Request;

class UniversityController extends Controller
{
    private UniversityService $universityService;

    public function __construct(UniversityService $universityService)
    {
        $this->universityService = $universityService;
    }

    public function index(Request $request)
    {
        $result = (object) $this->universityService->getUniversities($request);
        return view('modules.university.index', compact('result'));        
    }

    public function create()
    {
        return view('modules.university.create');
    }

    public function store(CreateUniversityRequest $request)
    {
        if($this->universityService->createUniversity($request)) {
            return redirect()->route('university.index')->with('success', 'University is created.');
        }
        return redirect()->route('university.index')->with('error', 'University is not created.');
    }

    public function edit($key)
    {
        $university = $this->universityService->getUniversityByKey($key);
        return view('modules.university.edit', compact('university'));
    }

    public function update(UpdateUniversityRequest $request, $key)
    {
        if($this->universityService->updateUniversity($request, $key)) {
            return redirect()->route('university.index')->with('success', 'University is updated.');
        }
        return redirect()->route('university.index')->with('error', 'University is not updated.');
    }
}
