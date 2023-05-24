<?php

namespace App\Http\Livewire\Backlog;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Database\Eloquent\Builder;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Backlog;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class BacklogProjectTable extends DataTableComponent
{
    use LivewireAlert;

    protected $model = Backlog::class;

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
                    fn ($value, $row, Column $column) => view('pages.project.table.actions-backlog')->withValue($value)
                ),
            Column::make("Name", "name")
                ->searchable()
                ->sortable(),
            Column::make("Story Point", "story_point")
                ->searchable()
                ->sortable(),
            Column::make("Sprint Iteration", "sprint_name")
                ->searchable()
                ->sortable(),
            Column::make('Description', 'description')
                ->searchable()
                ->format(
                    fn ($value, $row, Column $column) => view('pages.backlog.table.description')->withValue($value)
                ),
        ];
    }

    public function builder(): Builder
    {
        return Backlog::where('project_id', $this->project);
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
        $name = Backlog::where('id', $this->deleteId)->first()->name;

        Notification::create([
            'detail' => $name.' backlog has been deleted!',
            'type' => 2,
            'operation' => 4,
            'user_id' => Auth::user()->id,
            'team_id' => Auth::user()->currentTeam->id,
        ]);

        Backlog::find($this->deleteId)->delete();
        return $this->alert('success', 'Data has been deleted succesfully!', ['timerProgressBar' => true,]);
    }
}
