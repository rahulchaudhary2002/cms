<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\Session;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $academicYears = AcademicYear::get();
        
        foreach ($academicYears as $academicYear) {
            Session::create([
                'name' => $academicYear->name.'-jan-june',
                'academic_year_id' => $academicYear->id,
                'program_id' => 1,
                'semester_id' => 1
            ]);
            Session::create([
                'name' => $academicYear->name.'-jan-june',
                'academic_year_id' => $academicYear->id,
                'program_id' => 2,
                'semester_id' => 2
            ]);
        }
    }
}
