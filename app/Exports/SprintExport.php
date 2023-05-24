<?php

namespace App\Exports;

use App\Models\Sprint;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SprintExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public $sprints;

    public function __construct($sprints) {
        $this->sprints = $sprints;
    }

    public function collection()
    {
        return Sprint::whereIn('id', $this->sprints)->select('id', 'name', 'description', 'project_id', 'total_sp', 'focus_factor', 'start_date', 'end_date', 'created_at', 'updated_at')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Sprint Iteration',
            'Description',
            'Project ID',
            'Total Story Point',
            'Focus Factor',
            'Start Date',
            'End Date',
            'Created at',
            'Updated at',
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
