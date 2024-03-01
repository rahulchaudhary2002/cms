<?php

namespace Database\Seeders;

use App\Models\Program;
use App\Models\University;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $university = University::where('name', 'Tribhuvan University')->first();
        
        $programs = ['BCA', 'BIT'];
        
        foreach ($programs as $program) {
            Program::create([
                'name' => $program,
                'university_id' => $university->id
            ]);
        }
    }
}
