<?php

namespace App\Exports;

use App\Models\Task;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TaskExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Task::select('id', 'title', 'start_date', 'end_date', 'assignee', 'description', 'status', 'priority', 'project_id', 'sprint_id', 'backlog_id', 'created_at', 'updated_at')->get();
    }

    public function headings(): array
    {
        return [
            'ID', 
            'Title', 
            'Start Date', 
            'End Date', 
            'Assignee',
            'Description',
            'Status',
            'Priority',
            'Project ID',
            'Sprint ID',
            'Backlog ID',
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
