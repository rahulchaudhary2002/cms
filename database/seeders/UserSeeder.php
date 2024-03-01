<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Semester;
use App\Models\Session;
use App\Models\Student;
use App\Models\StudentCourse;
use App\Models\StudentSemester;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::where('key', 'teacher')->first();
        $permissionKeys = ['view-attendance', 'take-attendance', 'view-assignment', 'create-assignment', 'update-assignment', 'check-assignment', 'view-submission'];
        $permissions = Permission::whereIn('key', $permissionKeys)->get();
        $role->syncPermissions($permissions);

        $users = User::factory()->count(100)->create();

        foreach ($users as $user) {
            $students = Student::factory()->count(1)->create(['user_id' => $user->id]);
            
            foreach($students as $student) {
                $semester = Semester::where('order', 1)->where('program_id', $student->program_id)->first();
                $session = Session::where('is_active', 1)->where('academic_year_id', $student->academic_year_id)->where('program_id', $student->program_id)->where('semester_id', $semester->id)->first();
                $courses = Course::where('program_id', $student->program_id)->where('semester_id', $semester->id)->get();
                
                StudentSemester::create([
                    'student_id' => $student->id,
                    'semester_id' => $semester->id,
                    'session_id' => $session->id
                ]);
                
                foreach($courses as $course) {
                    StudentCourse::create([
                        'student_id' => $student->id,
                        'semester_id' => $semester->id,
                        'course_id' => $course->id
                    ]);
                }
            }

            $user->assignRole('student');
        }

        $user = User::create([
            'name' => 'Teacher',
            'email' => 'teacher@app.com',
            'mobile' => '9800000000',
            'password' => Hash::make('123456789'),
            'dob' => '2001-04-27',
            'temporary_address' => 'Chardobato, Bhaktapur',
            'permanent_address' => 'Khamariya, Kailali'
        ]);
        
        $user->assignRole('teacher');
        $user->givePermissions(['view-attendance', 'take-attendance', 'view-assignment', 'create-assignment', 'update-assignment', 'check-assignment', 'view-submission']);

        Teacher::create([
            'user_id' => $user->id
        ]);

        $user = User::create([
            'name' => 'Teacher1',
            'email' => 'teacher1@app.com',
            'mobile' => '9800000000',
            'password' => Hash::make('123456789'),
            'dob' => '2001-04-27',
            'temporary_address' => 'Chardobato, Bhaktapur',
            'permanent_address' => 'Khamariya, Kailali'
        ]);
        
        $user->assignRole('teacher');
        $user->givePermissions(['view-attendance', 'take-attendance', 'view-assignment', 'create-assignment', 'update-assignment', 'check-assignment', 'view-submission']);

        Teacher::create([
            'user_id' => $user->id
        ]);
    }
}
