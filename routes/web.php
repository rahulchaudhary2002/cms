<?php

use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ExaminationRecordController;
use App\Http\Controllers\ExaminationStageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\StudentAttendanceController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentSemesterController;
use App\Http\Controllers\TeacherCourseController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});
Route::middleware('auth')->group(function() {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::post('/ck-file-upload', [HomeController::class, 'ckFileUpload'])->name('ck-file-upload');
    Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
});

require __DIR__ . '/auth.php';

Route::middleware(['auth', 'checkPermission'])->group(function () {
    Route::name('permission.')->prefix('permission')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('index')->middleware('can:permission.view');
        Route::get('/create', [PermissionController::class, 'create'])->name('create')->middleware('can:permission.create');
        Route::post('/store', [PermissionController::class, 'store'])->name('store')->middleware('can:permission.create');
        Route::get('/edit/{key}', [PermissionController::class, 'edit'])->name('edit')->middleware('can:permission.update');
        Route::put('/update/{key}', [PermissionController::class, 'update'])->name('update')->middleware('can:permission.update');
    });

    Route::name('role.')->prefix('role')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('index')->middleware('can:role.view');
        Route::get('/create', [RoleController::class, 'create'])->name('create')->middleware('can:role.create');
        Route::post('/store', [RoleController::class, 'store'])->name('store')->middleware('can:role.create');
        Route::get('/edit/{key}', [RoleController::class, 'edit'])->name('edit')->middleware('can:role.update');
        Route::put('/update/{key}', [RoleController::class, 'update'])->name('update')->middleware('can:role.update');
    });

    Route::name('user.')->prefix('staff')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index')->middleware('can:user.view');
        Route::get('/create', [UserController::class, 'create'])->name('create')->middleware('can:user.create');
        Route::post('/store', [UserController::class, 'store'])->name('store')->middleware('can:user.create');
        Route::get('/edit/{key}', [UserController::class, 'edit'])->name('edit')->middleware('can:user.update');
        Route::put('/update/{key}', [UserController::class, 'update'])->name('update')->middleware('can:user.update');
        Route::get('/show/{key}', [UserController::class, 'show'])->name('show')->middleware('can:user.view');
    });

    Route::name('student.')->prefix('student')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('index')->middleware('can:student.view');
        Route::get('/create', [StudentController::class, 'create'])->name('create')->middleware('can:student.create');
        Route::post('/store', [StudentController::class, 'store'])->name('store')->middleware('can:student.create');
        Route::get('/edit/{key}', [StudentController::class, 'edit'])->name('edit')->middleware('can:student.update');
        Route::put('/update/{key}', [StudentController::class, 'update'])->name('update')->middleware('can:student.update');
        Route::get('/show/{key}', [StudentController::class, 'show'])->name('show')->middleware('can:student.view');
        Route::prefix('attendance')->name('attendance.')->group(function () {
            Route::get('/', [StudentAttendanceController::class, 'index'])->name('index')->middleware('can:student-attendance.view');
            Route::get('/take', [StudentAttendanceController::class, 'take'])->name('take')->middleware('can:student-attendance.create');
            Route::post('/store', [StudentAttendanceController::class, 'store'])->name('store')->middleware('can:student-attendance.create');
        });
    });

    Route::name('academic-year.')->prefix('academic-year')->group(function () {
        Route::get('/', [AcademicYearController::class, 'index'])->name('index')->middleware('can:academic-year.view');
        Route::get('/create', [AcademicYearController::class, 'create'])->name('create')->middleware('can:academic-year.create');
        Route::post('/store', [AcademicYearController::class, 'store'])->name('store')->middleware('can:academic-year.create');
        Route::get('/edit/{key}', [AcademicYearController::class, 'edit'])->name('edit')->middleware('can:academic-year.update');
        Route::put('/update/{key}', [AcademicYearController::class, 'update'])->name('update')->middleware('can:academic-year.update');
    });

    Route::name('university.')->prefix('university')->group(function () {
        Route::get('/', [UniversityController::class, 'index'])->name('index')->middleware('can:university.view');
        Route::get('/create', [UniversityController::class, 'create'])->name('create')->middleware('can:university.create');
        Route::post('/store', [UniversityController::class, 'store'])->name('store')->middleware('can:university.create');
        Route::get('/edit/{key}', [UniversityController::class, 'edit'])->name('edit')->middleware('can:university.update');
        Route::put('/update/{key}', [UniversityController::class, 'update'])->name('update')->middleware('can:university.update');
    });

    Route::name('program.')->prefix('program')->group(function () {
        Route::get('/', [ProgramController::class, 'index'])->name('index')->middleware('can:program.view');
        Route::get('/create', [ProgramController::class, 'create'])->name('create')->middleware('can:program.create');
        Route::post('/store', [ProgramController::class, 'store'])->name('store')->middleware('can:program.create');
        Route::get('/edit/{key}', [ProgramController::class, 'edit'])->name('edit')->middleware('can:program.update');
        Route::put('/update/{key}', [ProgramController::class, 'update'])->name('update')->middleware('can:program.update');
    });

    Route::name('semester.')->prefix('semester')->group(function () {
        Route::get('/', [SemesterController::class, 'index'])->name('index')->middleware('can:semester.view');
        Route::get('/create', [SemesterController::class, 'create'])->name('create')->middleware('can:semester.create');
        Route::post('/store', [SemesterController::class, 'store'])->name('store')->middleware('can:semester.create');
        Route::get('/edit/{key}', [SemesterController::class, 'edit'])->name('edit')->middleware('can:semester.update');
        Route::put('/update/{key}', [SemesterController::class, 'update'])->name('update')->middleware('can:semester.update');
        Route::name('assign.')->prefix('assign')->group(function () {
            Route::get('/{student_key}', [StudentSemesterController::class, 'create'])->name('create')->middleware('can:assign-semester.create');
            Route::post('/{student_key}', [StudentSemesterController::class, 'store'])->name('store')->middleware('can:assign-semester.create');
        });
        Route::get('/change', [StudentSemesterController::class, 'edit'])->name('change');
        Route::post('/change/{student_key}', [StudentSemesterController::class, 'update'])->name('change.update');
    });

    Route::name('course.')->prefix('course')->group(function () {
        Route::get('/', [CourseController::class, 'index'])->name('index')->middleware('can:course.view');
        Route::get('/create', [CourseController::class, 'create'])->name('create')->middleware('can:course.create');
        Route::post('/store', [CourseController::class, 'store'])->name('store')->middleware('can:course.create');
        Route::get('/edit/{key}', [CourseController::class, 'edit'])->name('edit')->middleware('can:course.update');
        Route::put('/update/{key}', [CourseController::class, 'update'])->name('update')->middleware('can:course.update');
        Route::name('assign.')->prefix('assign')->group(function () {
            Route::get('/{teacher_key}', [TeacherCourseController::class, 'create'])->name('create')->middleware('can:assign-course.create');
            Route::post('/{teacher_key}', [TeacherCourseController::class, 'store'])->name('store')->middleware('can:assign-course.create');
        });
    });

    Route::name('session.')->prefix('session')->group(function () {
        Route::get('/', [SessionController::class, 'index'])->name('index')->middleware('can:session.view');
        Route::get('/create', [SessionController::class, 'create'])->name('create')->middleware('can:session.create');
        Route::post('/store', [SessionController::class, 'store'])->name('store')->middleware('can:session.create');
        Route::get('/edit/{key}', [SessionController::class, 'edit'])->name('edit')->middleware('can:session.update');
        Route::put('/update/{key}', [SessionController::class, 'update'])->name('update')->middleware('can:session.update');
    });

    Route::name('assignment.')->prefix('assignment')->group(function () {
        Route::get('/', [AssignmentController::class, 'index'])->name('index')->middleware('can:assignment.view');
        Route::get('/create', [AssignmentController::class, 'create'])->name('create')->middleware('can:assignment.create');
        Route::post('/store', [AssignmentController::class, 'store'])->name('store')->middleware('can:assignment.create');
        Route::get('/edit/{key}', [AssignmentController::class, 'edit'])->name('edit')->middleware('can:assignment.update');
        Route::put('/update/{key}', [AssignmentController::class, 'update'])->name('update')->middleware('can:assignment.update');
        Route::get('/show/{key}', [AssignmentController::class, 'show'])->name('show')->middleware('can:assignment.view');
        Route::post('/upload-file', [AssignmentController::class, 'uploadFile'])->name('upload.file');
        Route::post('/remove-file', [AssignmentController::class, 'removeFile'])->name('remove.file');
        Route::name('submission.')->prefix('submission')->group(function () {
            Route::get('/view/{key}', [AssignmentController::class, 'submissions'])->name('index')->middleware('can:assignment-submission.viewAny');
            Route::get('/create/{key}', [AssignmentController::class, 'createSubmission'])->name('create')->middleware('can:assignment-submission.create');
            Route::post('/store/{key}', [AssignmentController::class, 'storeSubmission'])->name('store')->middleware('can:assignment-submission.create');
            Route::get('/show/{key}/{student_key}', [AssignmentController::class, 'showSubmission'])->name('show')->middleware('can:assignment-submission.view');
            Route::get('/check/{key}/{student_key}', [AssignmentController::class, 'check'])->name('check')->middleware('can:check-assignment-submission.create');
            Route::put('/checking/{key}/{student_key}', [AssignmentController::class, 'checking'])->name('checking')->middleware('can:check-assignment-submission.create');
        });
    });

    Route::name('examination.')->prefix('examination')->group(function () {
        Route::name('stage.')->prefix('stage')->group(function () {
            Route::get('/', [ExaminationStageController::class, 'index'])->name('index')->middleware('can:examination-stage.view');
            Route::get('/create', [ExaminationStageController::class, 'create'])->name('create')->middleware('can:examination-stage.create');
            Route::post('/store', [ExaminationStageController::class, 'store'])->name('store')->middleware('can:examination-stage.create');
            Route::get('/edit/{key}', [ExaminationStageController::class, 'edit'])->name('edit')->middleware('can:examination-stage.update');
            Route::put('/update/{key}', [ExaminationStageController::class, 'update'])->name('update')->middleware('can:examination-stage.update');
        });

        Route::name('record.')->prefix('record')->group(function () {
            Route::get('/', [ExaminationRecordController::class, 'index'])->name('index')->middleware('can:examination-record.viewAny');
            Route::get('/create/{examination_stage_key}/{student_key}', [ExaminationRecordController::class, 'create'])->name('create')->middleware('can:examination-record.create');
            Route::post('/store/{examination_stage_key}/{student_key}', [ExaminationRecordController::class, 'store'])->name('store')->middleware('can:examination-record.create');
            Route::get('/edit/{examination_stage_key}/{student_key}', [ExaminationRecordController::class, 'edit'])->name('edit')->middleware('can:examination-record.update');
            Route::put('/update/{examination_stage_key}/{student_key}', [ExaminationRecordController::class, 'update'])->name('update')->middleware('can:examination-record.update');
            Route::get('/show/{examination_stage_key}/{student_key}', [ExaminationRecordController::class, 'show'])->name('show')->middleware('can:examination-record.view');
            Route::get('/export-template', [ExaminationRecordController::class, 'exportTemplate'])->name('template.export')->middleware('can:examination-record.create');
            Route::get('/import', [ExaminationRecordController::class, 'importForm'])->name('import')->middleware('can:examination-record.create');
            Route::post('/import', [ExaminationRecordController::class, 'import'])->middleware('can:examination-record.create');
        });
    });

    Route::name('meeting.')->prefix('meeting')->group(function () {
        Route::get('/', [MeetingController::class, 'index'])->name('index')->middleware('can:meeting.view');
        Route::get('/create', [MeetingController::class, 'create'])->name('create')->middleware('can:meeting.create');
        Route::post('/store', [MeetingController::class, 'store'])->name('store')->middleware('can:meeting.create');
        Route::get('/edit/{key}', [MeetingController::class, 'edit'])->name('edit')->middleware('can:meeting.update');
        Route::put('/update/{key}', [MeetingController::class, 'update'])->name('update')->middleware('can:meeting.update');
    });
});
