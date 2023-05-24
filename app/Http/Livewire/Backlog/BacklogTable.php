<?php

namespace App\Http\Livewire\Backlog;

use App\Exports\BacklogExport;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Backlog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class BacklogTable extends DataTableComponent
{
    use LivewireAlert;

    protected $model = Backlog::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Actions")
                ->label(fn ($row, Column $column) => view('pages.backlog.table.actions')->with(['backlog' => $row])),
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Name", "name")
                ->searchable()
                ->sortable(),
            Column::make("Project", "projects.title")
                ->searchable()
                ->sortable(),
            Column::make("Sprint Iteration", "sprints.name")
                ->searchable()
                ->sortable(),
            Column::make("Story_point", "story_point")
                ->searchable()
                ->sortable(),
            Column::make('Description', 'description')
                ->format(
                    fn ($value, $row, Column $column) => view('pages.backlog.table.description')->withValue($value)
                ),
        ];
    }

    public function builder(): Builder
    {
        return Backlog::with('projects')->where('projects.team_id', Auth::user()->currentTeam->id);
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
        $backlogs = $this->getSelected();
        $total = count($backlogs);

        if ($total > 0) {
            $this->clearSelected();
            $currentDate = Carbon::now()->format('d-F-Y');
            return Excel::download(new BacklogExport($backlogs), 'Backlogs Data_' . $currentDate . '.xlsx');
        }

        $this->alert('warning', 'You did not select any backlogs to export.', ['timerProgressBar' => true,]);
    }

    public function exportCSV()
    {
        $backlogs = $this->getSelected();
        $total = count($backlogs);

        if ($total > 0) {
            $this->clearSelected();
            $currentDate = Carbon::now()->format('d-F-Y');
            return Excel::download(new BacklogExport($backlogs), 'Backlogs Data_' . $currentDate . '.CSV', \Maatwebsite\Excel\Excel::CSV);
        }
        
        $this->alert('warning', 'You did not select any backlogs to export.', ['timerProgressBar' => true,]);
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
        Backlog::find($this->deleteId)->delete();
        return $this->alert('success', 'Data has been deleted succesfully!', ['timerProgressBar' => true,]);
    }
}
