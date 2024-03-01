<?php

namespace Database\Seeders;

use App\Models\Program;
use App\Models\Semester;
use App\Models\University;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bca_program = Program::where('name', 'BCA')->first();
        $bit_program = Program::where('name', 'BIT')->first();

        $semesters = ['Semester 1', 'Semester 2', 'Semester 3', 'Semester 4', 'Semester 5', 'Semester 6', 'Semester 7', 'Semester 8'];
        
        foreach ($semesters as $key => $semester) {
            if($key + 1 == 7 || $key + 1 == 8) {
                $value = 2;
            }
            else {
                $value = null;
            }

            Semester::create([
                'name' => $semester,
                'program_id' => $bca_program->id,
                'order' => $key + 1,
                'number_of_elective_courses' => $value, 
            ]);

            if($key + 1 == 6 || $key + 1 == 7 || $key + 1 == 8) {
                $value = 1;
            }
            else {
                $value = null;
            }

            Semester::create([
                'name' => $semester,
                'program_id' => $bit_program->id,
                'order' => $key + 1,
                'number_of_elective_courses' => $value,
            ]);
        }
    }
}
