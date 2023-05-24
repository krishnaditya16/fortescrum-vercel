<?php

namespace App\Http\Livewire\Task;

use App\Exports\TaskExport;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Database\Eloquent\Builder;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TaskTable extends DataTableComponent
{
    use LivewireAlert;
    
    protected $model = Task::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make('Actions', 'id')
                ->format(
                    fn ($value, $row, Column $column) => view('pages.task.table.actions')->withValue($value)
                ),
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Title", "title")
                ->sortable(),
            Column::make("Start date", "start_date")
                ->sortable(),
            Column::make("End date", "end_date")
                ->sortable(),
            Column::make("Project", "projects.title")
                ->sortable(),
            Column::make("Board", "boards.title")
                ->sortable(),
            Column::make("Sprint", "sprints.name")
                ->sortable(),
            Column::make("Backlog", "backlogs.name")
                ->sortable(),
                Column::make("Assignee", "assignee")
                ->searchable()
                ->format(
                    fn ($value, $row, Column $column) => view('pages.project.table.task-assignee')->withValue($value)
                ),
            Column::make("Priority", "priority")
                ->searchable()
                ->format(
                    fn ($value, $row, Column $column) => view('pages.project.table.task-priority')->withValue($value)
                ),
            Column::make("Status", "status")
                ->searchable()
                ->format(
                    fn ($value, $row, Column $column) => view('pages.project.table.task-status')->withValue($value)
                ),
        ];
    }

    public function builder(): Builder
    {
        return Task::join('projects', 'tasks.project_id', 'projects.id')->where('projects.team_id', Auth::user()->currentTeam->id);
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
        $tasks = $this->getSelected();
        $total = count($tasks);

        if ($total > 0) {
            $this->clearSelected();
            $currentDate = Carbon::now()->format('d-F-Y');
            return Excel::download(new TaskExport($tasks), 'Tasks Data_' . $currentDate . '.xlsx');
        }

        $this->alert('warning', 'You did not select any tasks to export.', ['timerProgressBar' => true,]);
    }

    public function exportCSV()
    {
        $tasks = $this->getSelected();
        $total = count($tasks);

        if ($total > 0) {
            $this->clearSelected();
            $currentDate = Carbon::now()->format('d-F-Y');
            return Excel::download(new TaskExport($tasks), 'Tasks Data_' . $currentDate . '.CSV', \Maatwebsite\Excel\Excel::CSV);
        }
        
        $this->alert('warning', 'You did not select any tasks to export.', ['timerProgressBar' => true,]);
    }

    public function deleteConfirm($id)
    {
        $this->deleteId = $id;
        $this->confirm('Are you sure?', [
            'text' => "You won't be able to revert this!",
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes',
            'showCanceledButton' => true,
            'cancelButtonText' => 'No',
            'onConfirmed' => 'delete',
            'onDismissed' => 'cancel'
        ]);
    } 
    
    public function getListeners()
    {
        return ['delete', 'cancel'];
    }

    public function cancel()
    {
        return $this->alert('info', 'Delete has been cancelled.', ['timerProgressBar' => true,]);
    }

    public function delete()
    {
        Task::find($this->deleteId)->delete();
        return $this->alert('success', 'Data has been deleted succesfully!', ['timerProgressBar' => true,]);
    }
}
