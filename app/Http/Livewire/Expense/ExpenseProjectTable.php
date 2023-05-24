<?php

namespace App\Http\Livewire\Expense;

use App\Exports\ExpenseProjectExport;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Database\Eloquent\Builder;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Expense;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class ExpenseProjectTable extends DataTableComponent
{
    use LivewireAlert;

    protected $model = Expense::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function mount($project)
    {
        $this->project = $project;
    }

    public function columns(): array
    {
        return [
            Column::make('Actions', 'id')
                ->format(
                    fn ($value, $row, Column $column) => view('pages.project.table.actions-expenses')->withValue($value)
                ),
            Column::make("Date", "expenses_date")
                ->searchable()
                ->sortable(),
            Column::make("Description", "description")
                ->searchable()
                ->sortable(),
            Column::make("User", "team_member")
                ->searchable(function ($builder, $term) {
                    return $builder->orWhereHas('users', function($query) use($term){
                        $query->where('name', 'LIKE', '%' . $term . '%')->orWhere('email', 'LIKE', '%' . $term . '%');
                    });
                })
                ->format(
                    fn ($value, $row, Column $column) => view('pages.project.table.expenses-user')->with(['expense' => $row])
                ),
            Column::make("Ammount", "ammount")
                ->searchable()
                ->sortable()
                ->format(
                    fn($value, $row, Column $column) => '$'.number_format("$row->ammount",2)
                ),
            Column::make("Status", "expenses_status")
                ->searchable()
                ->format(
                    fn ($value, $row, Column $column) => view('pages.project.table.expenses-status')->withValue($value)
                ),
        ];
    }

    public function builder(): Builder
    {
        return Expense::where('project_id', $this->project);
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
        $expenses = $this->getSelected();
        $total = count($expenses);

        if ($total > 0) {
            $this->clearSelected();
            $currentDate = Carbon::now()->format('d-F-Y');
            return Excel::download(new ExpenseProjectExport($expenses), 'Project Expenses Data_' . $currentDate . '.xlsx');
        }

        $this->alert('warning', 'You did not select any expenses data to export.', ['timerProgressBar' => true,]);
    }

    public function exportCSV()
    {
        $expenses = $this->getSelected();
        $total = count($expenses);

        if ($total > 0) {
            $this->clearSelected();
            $currentDate = Carbon::now()->format('d-F-Y');
            return Excel::download(new ExpenseProjectExport($expenses), 'Project Expenses Data_' . $currentDate . '.CSV', \Maatwebsite\Excel\Excel::CSV);
        }
        
        $this->alert('warning', 'You did not select any expenses data to export.', ['timerProgressBar' => true,]);
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
        Expense::find($this->deleteId)->delete();
        return $this->alert('success', 'Data has been deleted succesfully!', ['timerProgressBar' => true,]);
    }
}
