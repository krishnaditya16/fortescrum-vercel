<?php

namespace App\Exports;

use App\Models\Project;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProjectExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public $projects;

    public function __construct($projects) {
        $this->projects = $projects;
    }

    public function collection()
    {
        return Project::whereIn('id', $this->projects)->select('id', 'title', 'start_date', 'end_date', 'progress','created_at', 'updated_at')->get();
    }

    public function headings(): array
    {
        return [
            'ID', 
            'Title', 
            'Start Date', 
            'End Date', 
            'Progress',
            'Created At', 
            'Updated At'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
        // Style the first row as bold text.
        1    => ['font' => ['bold' => true]],
        ];
    }
}
