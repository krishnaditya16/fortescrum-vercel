<?php

namespace App\Exports;

use App\Models\Timesheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TimesheetReportExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public $timesheets;

    public function __construct($timesheets) {
        $this->timesheets = $timesheets;
    }

    public function collection()
    {
        return Timesheet::whereIn('id', $this->timesheets)->select('id', 'work_date', 'start_time', 'end_time', 'user_id', 'project_id', 'task_id', 'team_id', 'created_at', 'updated_at')->get();
    }

    public function headings(): array
    {
        return [
            'ID', 
            'Date', 
            'Start Time', 
            'End Time', 
            'User',
            'Project',
            'Task',
            'Team',
            'Created At', 
            'Updated At'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
