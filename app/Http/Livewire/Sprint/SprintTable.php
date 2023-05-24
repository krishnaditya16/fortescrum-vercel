<?php

namespace App\Http\Livewire\Sprint;

use App\Exports\SprintExport;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Sprint;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Maatwebsite\Excel\Facades\Excel;

class SprintTable extends DataTableComponent
{
    use LivewireAlert;

    protected $model = Sprint::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Actions")
                ->label(fn ($row, Column $column) => view('pages.sprint.table.actions')->with(['sprint' => $row])),
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Project", "projects.title")
                ->searchable()
                ->sortable(),
            Column::make("Sprint Iteration", "name")
                ->searchable()
                ->sortable(),
            Column::make("Start Date", "start_date")
                ->searchable()
                ->sortable(),
            Column::make("End Date", "end_date")
                ->searchable()
                ->sortable(),
            Column::make("Focus Factor (%)", "focus_factor")
                ->searchable()
                ->sortable(),
            Column::make("Total Story point", "total_sp")
                ->searchable()
                ->sortable(),
            Column::make('Status', 'status')
                ->format(
                    fn ($value, $row, Column $column) => view('pages.sprint.table.status')->withValue($value)
                ),
        ];
    }

    public function builder(): Builder
    {
        return Sprint::with('projects')->where('projects.team_id', Auth::user()->currentTeam->id);
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
        $sprints = $this->getSelected();
        $total = count($sprints);

        if ($total > 0) {
            $this->clearSelected();
            $currentDate = Carbon::now()->format('d-F-Y');
            return Excel::download(new SprintExport($sprints), 'Sprints Data_' . $currentDate . '.xlsx');
        }

        $this->alert('warning', 'You did not select any sprints to export.', ['timerProgressBar' => true,]);
    }

    public function exportCSV()
    {
        $sprints = $this->getSelected();
        $total = count($sprints);

        if ($total > 0) {
            $this->clearSelected();
            $currentDate = Carbon::now()->format('d-F-Y');
            return Excel::download(new SprintExport($sprints), 'Sprints Data_' . $currentDate . '.CSV', \Maatwebsite\Excel\Excel::CSV);
        }
        
        $this->alert('warning', 'You did not select any sprints to export.', ['timerProgressBar' => true,]);
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
        Sprint::find($this->deleteId)->delete();
        return $this->alert('success', 'Data has been deleted succesfully!', ['timerProgressBar' => true,]);
    }
}
