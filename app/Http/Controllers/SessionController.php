<?php

namespace App\Http\Controllers;

use App\Http\Requests\Session\CreateSessionRequest;
use App\Http\Requests\Session\UpdateSessionRequest;
use App\Services\SessionService;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    private SessionService $sessionService;

    public function __construct(SessionService $sessionService)
    {
        $this->sessionService = $sessionService;
    }

    public function index(Request $request)
    {
        $result = (object) $this->sessionService->getSessions($request);
        $academicYears = $this->sessionService->getAcademicYears();
        $programs = $this->sessionService->getPrograms();
        $semesters = $this->sessionService->getSemestersWithProgram();
        
        return view('modules.session.index', compact('result', 'academicYears', 'programs', 'semesters'));
    }

    public function create()
    {
        $academicYears = $this->sessionService->getAcademicYears();
        $programs = $this->sessionService->getPrograms();
        $semesters = $this->sessionService->getSemestersWithProgram();

        return view('modules.session.create', compact('academicYears', 'programs', 'semesters'));
    }

    public function store(CreateSessionRequest $request)
    {
        if ($this->sessionService->createSession($request)) {
            return redirect()->route('session.index')->with('success', 'Session is created.');
        }
        return redirect()->route('session.index')->with('error', 'Session is not created.');
    }

    public function edit($key)
    {
        $session = $this->sessionService->getSessionByKey($key);

        return view('modules.session.edit', compact('session'));
    }

    public function update(UpdateSessionRequest $request, $key)
    {
        if ($this->sessionService->updateSession($request, $key)) {
            return redirect()->route('session.index')->with('success', 'Session is updated.');
        }
        return redirect()->route('session.index')->with('error', 'Session is not updated.');
    }
}
