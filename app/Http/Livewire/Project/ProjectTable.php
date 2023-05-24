<?php

namespace App\Http\Livewire\Project;

use App\Exports\ProjectExport;
use App\Models\Notification;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Maatwebsite\Excel\Facades\Excel;

class ProjectTable extends DataTableComponent
{
    use LivewireAlert;

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
            Column::make("Id", "id")
                ->collapseOnTablet()
                ->searchable()
                ->sortable(),
            Column::make("Title", "title")
                ->collapseOnTablet()
                ->searchable()
                ->sortable(),
            Column::make("Client", "client.name")
                ->searchable()
                ->sortable(),
            Column::make("Team", "team.name")
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
                    fn ($value, $row, Column $column) => view('pages.project.table.status')->with(['row' => $row])
                ),
        ];
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

    public function builder(): Builder
    {
        $team = Auth::user()->currentTeam;
        return Project::where('team_id', $team->id);
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
        $title = Project::where('id', $this->deleteId)->first()->title;
        $file = Project::where('id', $this->deleteId)->first()->proposal;
        if($oldFile = $file) {
            unlink(public_path('uploads/proposal/') . $oldFile);
        }
        Project::find($this->deleteId)->delete();

        Notification::create([
            'detail' => $title.' has been deleted!',
            'type' => 0,
            'operation' => 4,
            'user_id' => Auth::user()->id,
            'team_id' => Auth::user()->currentTeam->id,
        ]);

        return $this->alert('success', 'Data has been deleted succesfully!', ['timerProgressBar' => true,]);
    }
}
