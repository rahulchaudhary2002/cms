<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcademicYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = ['2021', '2022', '2023', '2024', '2025'];

        foreach ($names as $value) {
            AcademicYear::create([
                'name' => $value,
            ]);
        }
    }
}
