<?php

namespace App\Http\Controllers;

use App\Http\Requests\AcademicYear\CreateAcademicYearRequest;
use App\Http\Requests\AcademicYear\UpdateAcademicYearRequest;
use App\Services\AcademicYearService;
use Illuminate\Http\Request;

class AcademicYearController extends Controller
{
    private AcademicYearService $academicYearService;

    public function __construct(AcademicYearService $academicYearService)
    {
        $this->academicYearService = $academicYearService;
    }

    public function index(Request $request)
    {
        $result = (object) $this->academicYearService->getAcademicYears($request);
        return view('modules.academicYear.index', compact('result'));        
    }

    public function create()
    {
        return view('modules.academicYear.create');
    }

    public function store(CreateAcademicYearRequest $request)
    {
        if($this->academicYearService->createAcademicYear($request)) {
            return redirect()->route('academic-year.index')->with('success', 'Academic year is created.');
        }
        return redirect()->route('academic-year.index')->with('error', 'Academic year is not created.');
    }

    public function edit($key)
    {
        $academicYear = $this->academicYearService->getAcademicYearByKey($key);
        return view('modules.academicYear.edit', compact('academicYear'));
    }

    public function update(UpdateAcademicYearRequest $request, $key)
    {
        if($this->academicYearService->updateAcademicYear($request, $key)) {
            return redirect()->route('academic-year.index')->with('success', 'Academic year is updated.');
        }
        return redirect()->route('academic-year.index')->with('error', 'Academic year is not updated.');
    }
}