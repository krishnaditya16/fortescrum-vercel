<?php

namespace App\Http\Livewire\Finance;

use App\Exports\InvoiceProjectExport;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Database\Eloquent\Builder;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Invoice;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class InvoiceProjectTable extends DataTableComponent
{
    use LivewireAlert;

    protected $model = Invoice::class;

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
                    fn ($value, $row, Column $column) => view('pages.finance.table.actions-invoice')->withValue($value)
                ),
            Column::make("Id", "id")
                ->searchable()
                ->sortable()
                ->format(
                    fn($value, $row, Column $column) => '#INV-'.$row->id
                ),
            Column::make("Issued", "issued")
                ->searchable()
                ->sortable(),
            Column::make("Deadline", "deadline")
                ->searchable()
                ->sortable(),
            Column::make("Total all", "total_all")
                ->searchable()
                ->sortable()
                ->format(
                    fn($value, $row, Column $column) => '$'.number_format("$row->total_all",2)
                ),
            Column::make("Client", "clients.name")
                ->searchable()
                ->sortable(),
            Column::make("Status", "inv_status")
                ->searchable()
                ->format(
                    fn ($value, $row, Column $column) => view('pages.finance.table.invoice-status')->with(['row' => $row])
                ),
        ];
    }

    public function builder(): Builder
    {
        return Invoice::where('project_id', $this->project);
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
        $invoices = $this->getSelected();
        $total = count($invoices);

        if ($total > 0) {
            $this->clearSelected();
            $currentDate = Carbon::now()->format('d-F-Y');
            return Excel::download(new InvoiceProjectExport($invoices), 'Invoices Data_' . $currentDate . '.xlsx');
        }

        $this->alert('warning', 'You did not select any Invoices to export.', ['timerProgressBar' => true,]);
    }

    public function exportCSV()
    {
        $invoices = $this->getSelected();
        $total = count($invoices);

        if ($total > 0) {
            $this->clearSelected();
            $currentDate = Carbon::now()->format('d-F-Y');
            return Excel::download(new InvoiceProjectExport($invoices), 'Invoices Data_' . $currentDate . '.CSV', \Maatwebsite\Excel\Excel::CSV);
        }
        
        $this->alert('warning', 'You did not select any Invoices to export.', ['timerProgressBar' => true,]);
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
        Invoice::find($this->deleteId)->delete();
        return $this->alert('success', 'Data has been deleted succesfully!', ['timerProgressBar' => true,]);
    }
}
