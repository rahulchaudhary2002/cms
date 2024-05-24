<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;

class ExaminationRecordTemplate implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    private $request;
    private $students;
    private $headings;

    public function __construct($request, $students, $headings)
    {
        $this->request = $request;
        $this->students = $students;
        $this->headings = $headings;
    }

    public function collection()
    {
        $nullColumnsCount = count($this->headings) - 2;

        $data = [];
        foreach ($this->students as $student) {
            $row = [$student->student->id, $student->name];
            $row = array_merge($row, array_fill(0, $nullColumnsCount, null));
            $data[] = $row;
        }

        return new Collection($data);
    }

    public function headings(): array
    {
        return $this->headings;
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Insert data before headings
                $sheet->setCellValue('A1', 'Academic Year');
                $sheet->setCellValue('B1', $this->request->academic_year);
                $sheet->setCellValue('A2', 'Program');
                $sheet->setCellValue('B2', $this->request->program);
                $sheet->setCellValue('A3', 'Semester');
                $sheet->setCellValue('B3', $this->request->semester);
                $sheet->setCellValue('A4', 'Session');
                $sheet->setCellValue('B4', $this->request->session);
                $sheet->setCellValue('A5', 'Examination Stage');
                $sheet->setCellValue('B5', $this->request->examination_stage);
                $sheet->setCellValue('A6', '');

                $sheet->getProtection()->setSheet(true);
            },
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->getProtection()->setSheet(true);

                // Unlock the cells under each heading, excluding the heading row itself
                $highestRow = $sheet->getHighestRow(); // Get the highest row number
                $highestColumn = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($this->headings)); // Get the highest column letter

                // Unlock all rows starting from row 2 (first data row) to the last row with data
                $range = 'C8:' . $highestColumn . $highestRow;
                $sheet->getStyle($range)->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);

                // Optionally, apply other styles
                $sheet->getStyle('A7:' . $highestColumn . '1')->getFont()->setBold(true); // Make the header row bold
            }
        ];
    }
}
