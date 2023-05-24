<?php

namespace App\Http\Livewire\Timesheet;

use App\Exports\TimesheetReportExport;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Database\Eloquent\Builder;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Timesheet;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class TimesheetReportTable extends DataTableComponent
{
    use LivewireAlert;

    protected $model = Timesheet::class;

    public function mount($project)
    {
        $this->project = $project;
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->searchable()
                ->sortable(),
            Column::make("User", "user_id")
                ->searchable(function ($builder, $term) {
                    return $builder->orWhereHas('users', function($query) use($term){
                        $query->where('name', 'LIKE', '%' . $term . '%')->orWhere('email', 'LIKE', '%' . $term . '%');
                    });
                })
                ->format(
                    fn ($value, $row, Column $column) => view('pages.report.table.user')->with(['time' => $row])
                ),
            Column::make("Task", "task_id")
                ->searchable()
                ->format(
                    fn ($value, $row, Column $column) => view('pages.report.table.task')->with(['time' => $row])
                ),
            Column::make("Date", "work_date")
                ->searchable()
                ->sortable(),
            Column::make("Time", "id")
                ->searchable()
                ->format(
                    fn ($value, $row, Column $column) => view('pages.report.table.time')->with(['time' => $row])
                ),
            Column::make("Created at", "created_at")
                ->searchable()
                ->sortable(),
        ];
    }

    public function builder(): Builder
    {
        return Timesheet::where('project_id', $this->project);
    }

    public function bulkActions(): array
    {
        return [
            'exportXLS' => 'Export Excel',
            'exportCSV' => 'Export CSV',
        ];
    }

    public function exportXLS()
    {
        $timesheets = $this->getSelected();
        $total = count($timesheets);

        if ($total > 0) {
            $this->clearSelected();
            $currentDate = Carbon::now()->format('d-F-Y');
            return Excel::download(new TimesheetReportExport($timesheets), 'Project Timesheet Data_' . $currentDate . '.xlsx');
        }

        $this->alert('warning', 'You did not select any timesheets to export.', ['timerProgressBar' => true,]);
    }

    public function exportCSV()
    {
        $timesheets = $this->getSelected();
        $total = count($timesheets);

        if ($total > 0) {
            $this->clearSelected();
            $currentDate = Carbon::now()->format('d-F-Y');
            return Excel::download(new TimesheetReportExport($timesheets), 'Project Timesheet Data_' . $currentDate . '.CSV', \Maatwebsite\Excel\Excel::CSV);
        }
        
        $this->alert('warning', 'You did not select any timesheets to export.', ['timerProgressBar' => true,]);
    }
}
