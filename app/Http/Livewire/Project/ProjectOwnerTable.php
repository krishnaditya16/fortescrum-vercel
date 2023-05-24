<?php

namespace App\Http\Livewire\Project;

use App\Exports\ProjectExport;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ProjectOwnerTable extends DataTableComponent
{
    protected $model = Project::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Actions")
                ->label(fn ($row, Column $column) => view('pages.project.table.actions')->with(['project' => $row])),
            Column::make("Title", "title")
                ->collapseOnTablet()
                ->searchable()
                ->sortable(),
            Column::make("Client", "client.name")
                ->searchable()
                ->sortable(),
            Column::make("Team", "team.name")
                ->collapseOnTablet()
                ->searchable()
                ->sortable(),
            Column::make("Due date", "end_date")
                ->collapseOnTablet()
                ->searchable()
                ->sortable(),
            Column::make("Progress", "progress")
                ->searchable()
                ->format(
                    fn ($value, $row, Column $column) => view('pages.project.table.progress')->withValue($row)
                ),
            Column::make("Status", "status")
                ->collapseOnTablet()
                ->searchable()
                ->format(
                    fn ($value, $row, Column $column) => view('pages.project.table.status')->withValue($value)
                ),
        ];
    }

    public function builder(): Builder
    {
        $client = Auth::user()->client_id;

        return Project::query()
            ->where('projects.client_id', $client)
            ->select('projects.id', 'projects.title', 'clients.name', 'teams.name', 'projects.end_date', 'projects.progress', 'projects.status');
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
        $projects = $this->getSelected();
        $total = count($projects);

        if ($total > 0) {
            $this->clearSelected();
            $currentDate = Carbon::now()->format('d-F-Y');
            return Excel::download(new ProjectExport($projects), 'Projects Data_' . $currentDate . '.xlsx');
        }

        $this->alert('warning', 'You did not select any projects to export.', ['timerProgressBar' => true,]);
    }

    public function exportCSV()
    {
        $projects = $this->getSelected();
        $total = count($projects);

        if ($total > 0) {
            $this->clearSelected();
            $currentDate = Carbon::now()->format('d-F-Y');
            return Excel::download(new ProjectExport($projects), 'Projects Data_' . $currentDate . '.CSV', \Maatwebsite\Excel\Excel::CSV);
        }
        
        $this->alert('warning', 'You did not select any projects to export.', ['timerProgressBar' => true,]);
    }
}
