<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Program;
use App\Models\Semester;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bit = Program::where('name', 'BIT')->first();
        $bca = Program::where('name', 'BCA')->first();

        $bit_sem1 = Semester::where('name', 'Semester 1')->where('program_id', $bit->id)->first();
        $bit_sem2 = Semester::where('name', 'Semester 2')->where('program_id', $bit->id)->first();
        $bit_sem3 = Semester::where('name', 'Semester 3')->where('program_id', $bit->id)->first();
        $bit_sem4 = Semester::where('name', 'Semester 4')->where('program_id', $bit->id)->first();
        $bit_sem5 = Semester::where('name', 'Semester 5')->where('program_id', $bit->id)->first();
        $bit_sem6 = Semester::where('name', 'Semester 6')->where('program_id', $bit->id)->first();
        $bit_sem7 = Semester::where('name', 'Semester 7')->where('program_id', $bit->id)->first();
        $bit_sem8 = Semester::where('name', 'Semester 8')->where('program_id', $bit->id)->first();

        $bca_sem1 = Semester::where('name', 'Semester 1')->where('program_id', $bca->id)->first();
        $bca_sem2 = Semester::where('name', 'Semester 2')->where('program_id', $bca->id)->first();
        $bca_sem3 = Semester::where('name', 'Semester 3')->where('program_id', $bca->id)->first();
        $bca_sem4 = Semester::where('name', 'Semester 4')->where('program_id', $bca->id)->first();
        $bca_sem5 = Semester::where('name', 'Semester 5')->where('program_id', $bca->id)->first();
        $bca_sem6 = Semester::where('name', 'Semester 6')->where('program_id', $bca->id)->first();
        $bca_sem7 = Semester::where('name', 'Semester 7')->where('program_id', $bca->id)->first();
        $bca_sem8 = Semester::where('name', 'Semester 8')->where('program_id', $bca->id)->first();

        $bit_courses = [
            // Semester 1 Courses
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem1->id,
                'course_code' => 'BIT101',
                'name' => 'Introduction to Information Technology',
                'credit' => 3
            ],
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem1->id,
                'course_code' => 'BIT102',
                'name' => 'C Programming',
                'credit' => 3
            ],
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem1->id,
                'course_code' => 'BIT103',
                'name' => 'Digital Logic',
                'credit' => 3
            ],
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem1->id,
                'course_code' => 'MTH104',
                'name' => 'Basic Mathematics',
                'credit' => 3
            ],
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem1->id,
                'course_code' => 'SCO105',
                'name' => 'Sociology',
                'credit' => 3
            ],
            // Semester 2 Courses
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem2->id,
                'course_code' => 'BIT151',
                'name' => 'Microprocessor and Computer Architecture',
                'credit' => 3
            ],
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem2->id,
                'course_code' => 'BIT152',
                'name' => 'Discrete Structure',
                'credit' => 3
            ],
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem2->id,
                'course_code' => 'BIT153',
                'name' => 'Object Oriented Programming',
                'credit' => 3
            ],
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem2->id,
                'course_code' => 'STA154',
                'name' => 'Basic Statistics',
                'credit' => 3
            ],
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem2->id,
                'course_code' => 'ECO155',
                'name' => 'Economics',
                'credit' => 3
            ],
            // Semester 3 Courses
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem3->id,
                'course_code' => 'BIT201',
                'name' => 'Data Structures and Algorithms',
                'credit' => 3
            ],
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem3->id,
                'course_code' => 'BIT202',
                'name' => 'Database Management System',
                'credit' => 3
            ],
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem3->id,
                'course_code' => 'BIT203',
                'name' => 'Numerical Methods',
                'credit' => 3
            ],
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem3->id,
                'course_code' => 'BIT204',
                'name' => 'Operating Systems',
                'credit' => 3
            ],
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem3->id,
                'course_code' => 'MGT205',
                'name' => 'Principles of Management',
                'credit' => 3
            ],
            // Semester 4 Courses
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem4->id,
                'course_code' => 'BIT251',
                'name' => 'Web Technology I',
                'credit' => 3
            ],
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem4->id,
                'course_code' => 'BIT252',
                'name' => 'Artificial Intelligence',
                'credit' => 3
            ],
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem4->id,
                'course_code' => 'BIT253',
                'name' => 'Systems Analysis and Design',
                'credit' => 3
            ],
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem4->id,
                'course_code' => 'BIT254',
                'name' => 'Network and Data Communications',
                'credit' => 3
            ],
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem4->id,
                'course_code' => 'ORS255',
                'name' => 'Operations Research',
                'credit' => 3
            ],
            // Semester 5 Courses
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem5->id,
                'course_code' => 'BIT301',
                'name' => 'Web Technology II',
                'credit' => 3
            ],
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem5->id,
                'course_code' => 'BIT302',
                'name' => 'Software Engineering',
                'credit' => 3
            ],
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem5->id,
                'course_code' => 'BIT303',
                'name' => 'Information Security',
                'credit' => 3
            ],
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem5->id,
                'course_code' => 'BIT304',
                'name' => 'Computer Graphics',
                'credit' => 3
            ],
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem5->id,
                'course_code' => 'ENG305',
                'name' => 'Technical Writing',
                'credit' => 3
            ],
            //  Semester 6 Courses
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem6->id,
                'course_code' => 'BIT351',
                'name' => 'NET Centric Computing',
                'credit' => 3
            ],
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem6->id,
                'course_code' => 'BIT352',
                'name' => 'Database Administration',
                'credit' => 3
            ],
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem6->id,
                'course_code' => 'BIT353',
                'name' => 'Management Information System',
                'credit' => 3
            ],
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem6->id,
                'course_code' => 'RSM354',
                'name' => 'Research Methodology',
                'credit' => 3
            ],
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem6->id,
                'course_code' => 'BIT355',
                'name' => 'Geographical Information System',
                'credit' => 3,
                'elective' => 1
            ],
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem6->id,
                'course_code' => 'BIT356',
                'name' => 'Multimedia Computing',
                'credit' => 3,
                'elective' => 1
            ],
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem6->id,
                'course_code' => 'BIT357',
                'name' => 'Wireless Networking',
                'credit' => 3,
                'elective' => 1
            ],
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem6->id,
                'course_code' => 'BIT358',
                'name' => 'Society and Ethics in IT',
                'credit' => 3,
                'elective' => 1
            ],
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem6->id,
                'course_code' => 'PSY359',
                'name' => 'Psychology',
                'credit' => 3,
                'elective' => 1
            ],
            // Semester 7 Courses
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem7->id,
                'course_code' => 'BIT401',
                'name' => 'Advanced Java Programming',
                'credit' => 3
            ],
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem7->id,
                'course_code' => 'BIT402',
                'name' => 'Software Project Management',
                'credit' => 3
            ],
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem7->id,
                'course_code' => 'BIT403',
                'name' => 'E-commerce',
                'credit' => 3
            ],
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem7->id,
                'course_code' => 'BIT404',
                'name' => 'Project work',
                'credit' => 3
            ],
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem7->id,
                'course_code' => 'BIT405',
                'name' => 'DSS and Expert System',
                'credit' => 3,
                'elective' => 1
            ],
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem7->id,
                'course_code' => 'BIT406',
                'name' => 'Mobile Application Development',
                'credit' => 3,
                'elective' => 1
            ],
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem7->id,
                'course_code' => 'BIT407',
                'name' => 'Simulation and Modeling',
                'credit' => 3,
                'elective' => 1
            ],
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem7->id,
                'course_code' => 'BIT408',
                'name' => 'Cloud Computing',
                'credit' => 3,
                'elective' => 1
            ],
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem7->id,
                'course_code' => 'MGT409',
                'name' => 'Marketing',
                'credit' => 3,
                'elective' => 1
            ],
            // Semester 8 Courses
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem8->id,
                'course_code' => 'BIT451',
                'name' => 'Network and System Administration',
                'credit' => 3
            ],
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem8->id,
                'course_code' => 'BIT452',
                'name' => 'E Governance',
                'credit' => 3
            ],
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem8->id,
                'course_code' => 'BIT453',
                'name' => 'Internship',
                'credit' => 3
            ],
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem8->id,
                'course_code' => 'BIT454',
                'name' => 'Data Warehousing and Data Mining',
                'credit' => 3,
                'elective' => 1
            ],
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem8->id,
                'course_code' => 'BIT455',
                'name' => 'Knowledge Management',
                'credit' => 3,
                'elective' => 1
            ],
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem8->id,
                'course_code' => 'BIT456',
                'name' => 'Image processing',
                'credit' => 3,
                'elective' => 1
            ],
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem8->id,
                'course_code' => 'BIT457',
                'name' => 'Network Security',
                'credit' => 3,
                'elective' => 1
            ],
            [
                'program_id' => $bit->id,
                'semester_id' => $bit_sem8->id,
                'course_code' => 'BIT458',
                'name' => 'Introduction to Telecommunications',
                'credit' => 3,
                'elective' => 1
            ]
        ];

        $bca_courses = [
            // Semester 1 Courses
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem1->id,
                'course_code' => 'CACS101',
                'name' => 'Computer Fundamentals & Applications',
                'credit' => 4
            ],
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem1->id,
                'course_code' => 'CASO102',
                'name' => 'Society and Technology',
                'credit' => 3
            ],
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem1->id,
                'course_code' => 'CAEN103',
                'name' => 'English I',
                'credit' => 3
            ],
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem1->id,
                'course_code' => 'CAMT104',
                'name' => 'Mathematics I',
                'credit' => 3
            ],
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem1->id,
                'course_code' => 'CACS105',
                'name' => 'Digital Logic',
                'credit' => 3
            ],
            // Semester 2 Courses
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem2->id,
                'course_code' => 'CACS151',
                'name' => 'C programming',
                'credit' => 4
            ],
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem2->id,
                'course_code' => 'CAAC152',
                'name' => 'Financial Accounting',
                'credit' => 3
            ],
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem2->id,
                'course_code' => 'CAEN153',
                'name' => 'English II',
                'credit' => 3
            ],
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem2->id,
                'course_code' => 'CAMT154',
                'name' => 'Mathematics II',
                'credit' => 3
            ],
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem2->id,
                'course_code' => 'CACS155',
                'name' => 'Microprocessor and Computer Architecture',
                'credit' => 3
            ],
            // Semester 3 Courses
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem3->id,
                'course_code' => 'CACS201',
                'name' => 'Data Structure and Algorithms',
                'credit' => 3
            ],
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem3->id,
                'course_code' => 'CAST202',
                'name' => 'Probability and Statistics',
                'credit' => 3
            ],
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem3->id,
                'course_code' => 'CACS203',
                'name' => 'System Analysis and Design',
                'credit' => 3
            ],
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem3->id,
                'course_code' => 'CACS204',
                'name' => 'OOP in Java',
                'credit' => 3
            ],
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem3->id,
                'course_code' => 'CACS205',
                'name' => 'Web Technology',
                'credit' => 3
            ],
            // Semester 4 Courses
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem4->id,
                'course_code' => 'CACS251',
                'name' => 'Operating System',
                'credit' => 4
            ],
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem4->id,
                'course_code' => 'CACS252',
                'name' => 'Numerical Methods',
                'credit' => 3
            ],
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem4->id,
                'course_code' => 'CACS253',
                'name' => 'Software Engineering',
                'credit' => 3
            ],
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem4->id,
                'course_code' => 'CACS254',
                'name' => 'Scripting Language',
                'credit' => 3
            ],
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem4->id,
                'course_code' => 'CACS255',
                'name' => 'Database Management System',
                'credit' => 3
            ],
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem4->id,
                'course_code' => 'CAPJ256',
                'name' => 'Project I',
                'credit' => 2
            ],
            // Semester 5 Courses
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem5->id,
                'course_code' => 'CACS301',
                'name' => 'MIS and e-Business',
                'credit' => 3
            ],
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem5->id,
                'course_code' => 'CACS302',
                'name' => 'DotNet Technology',
                'credit' => 3
            ],
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem5->id,
                'course_code' => 'CACS303',
                'name' => 'Computer Networking',
                'credit' => 3
            ],
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem5->id,
                'course_code' => 'CAMG304',
                'name' => 'Introduction to Management',
                'credit' => 3
            ],
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem5->id,
                'course_code' => 'CACS305',
                'name' => 'Computer Graphics and Animation',
                'credit' => 3
            ],
            //  Semester 6 Courses
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem6->id,
                'course_code' => 'CACS351',
                'name' => 'Mobile Programming',
                'credit' => 3
            ],
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem6->id,
                'course_code' => 'CACS352',
                'name' => 'Distributed System',
                'credit' => 3
            ],
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem6->id,
                'course_code' => 'CACS353',
                'name' => 'Applied Economics',
                'credit' => 3
            ],
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem6->id,
                'course_code' => 'CACS354',
                'name' => 'Advanced Java Programming',
                'credit' => 3
            ],
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem6->id,
                'course_code' => 'CACS355',
                'name' => 'Network Programming',
                'credit' => 3
            ],
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem6->id,
                'course_code' => 'CAPJ356',
                'name' => 'Project II',
                'credit' => 2
            ],
            // Semester 7 Courses
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem7->id,
                'course_code' => 'CACS401',
                'name' => 'Cyber Law and Professional Ethics',
                'credit' => 3
            ],
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem7->id,
                'course_code' => 'CACS402',
                'name' => 'Cloud Computing',
                'credit' => 3
            ],
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem7->id,
                'course_code' => 'CAIN103',
                'name' => 'Internship',
                'credit' => 3
            ],
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem7->id,
                'course_code' => 'CACS404',
                'name' => 'Image Processing',
                'credit' => 3,
                'elective' => 1
            ],
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem7->id,
                'course_code' => 'CACS405',
                'name' => 'Database Administration',
                'credit' => 3,
                'elective' => 1
            ],
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem7->id,
                'course_code' => 'CACS406',
                'name' => 'Network Administration',
                'credit' => 3,
                'elective' => 1
            ],
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem7->id,
                'course_code' => 'CACS408',
                'name' => 'Advanced Dot Net Technology',
                'credit' => 3,
                'elective' => 1
            ],
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem7->id,
                'course_code' => 'CACS409',
                'name' => 'E-Governance',
                'credit' => 3,
                'elective' => 1
            ],
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem7->id,
                'course_code' => 'CACS410',
                'name' => 'Artificial Intelligence',
                'credit' => 3,
                'elective' => 1
            ],
            // Semester 8 Courses
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem8->id,
                'course_code' => 'CAOR451',
                'name' => 'Operations Research',
                'credit' => 3
            ],
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem8->id,
                'course_code' => 'CAPJ452',
                'name' => 'Project III',
                'credit' => 3
            ],
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem8->id,
                'course_code' => 'CACS453',
                'name' => 'Database Programming',
                'credit' => 3,
                'elective' => 1
            ],
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem8->id,
                'course_code' => 'CACS454',
                'name' => 'Geographical Information System',
                'credit' => 3,
                'elective' => 1
            ],
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem8->id,
                'course_code' => 'CACS455',
                'name' => 'Data Analysis and Visualization',
                'credit' => 3,
                'elective' => 1
            ],
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem8->id,
                'course_code' => 'CACS456',
                'name' => 'Machine Learning',
                'credit' => 3,
                'elective' => 1
            ],
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem8->id,
                'course_code' => 'CACS457',
                'name' => 'Multimedia System',
                'credit' => 3,
                'elective' => 1
            ],
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem8->id,
                'course_code' => 'CACS458',
                'name' => 'Knowledge Engineering',
                'credit' => 3,
                'elective' => 1
            ],
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem8->id,
                'course_code' => 'CACS459',
                'name' => 'Information Security',
                'credit' => 3,
                'elective' => 1
            ],
            [
                'program_id' => $bca->id,
                'semester_id' => $bca_sem8->id,
                'course_code' => 'CACS460',
                'name' => 'Internet of Things',
                'credit' => 3,
                'elective' => 1
            ]
        ];

        foreach($bit_courses as $course) {
            Course::create($course);
        }

        foreach($bca_courses as $course) {
            Course::create($course);
        }
    }
}
