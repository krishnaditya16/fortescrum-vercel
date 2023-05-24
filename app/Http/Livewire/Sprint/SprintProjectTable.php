<?php

namespace App\Http\Livewire\Sprint;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Database\Eloquent\Builder;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Sprint;

class SprintProjectTable extends DataTableComponent
{
    use LivewireAlert;

    protected $model = Sprint::class;

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
            Column::make('Actions', 'id')
                ->format(
                    fn ($value, $row, Column $column) => view('pages.project.table.actions-sprint')->withValue($value)
                ),
            Column::make("Sprint Iteration", "name")
                ->sortable()
                ->searchable(),
            Column::make("Start Date", "start_date")
                ->sortable()
                ->searchable(),
            Column::make("End Date", "end_date")
                ->sortable()
                ->searchable(),
            Column::make("Focus Factor (%)", "focus_factor")
                ->sortable()
                ->searchable(),
            Column::make("Total Story point", "total_sp")
                ->sortable()
                ->searchable(),
            Column::make("Status", "status")
                ->collapseOnTablet()
                ->searchable()
                ->format(
                    fn ($value, $row, Column $column) => view('pages.sprint.table.status')->withValue($value)
                ),
            Column::make('Description', 'description')
                ->searchable()
                ->format(
                    fn ($value, $row, Column $column) => view('pages.sprint.table.description')->withValue($value)
                ),
        ];
    }

    public function builder(): Builder
    {
        return Sprint::where('project_id', $this->project);
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
