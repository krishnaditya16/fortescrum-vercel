<?php

namespace App\Exports;

use App\Models\Task;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TaskProjectExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public $tasks;

    public function __construct($tasks) {
        $this->tasks = $tasks;
    }

    public function collection()
    {
        return Task::whereIn('id', $this->tasks)->select('id', 'title', 'start_date', 'end_date', 'assignee', 'description', 'status', 'priority', 'created_at', 'updated_at')->get();
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
