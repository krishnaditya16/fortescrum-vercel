<?php

namespace App\Http\Livewire\Client;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Client;
use App\Exports\ClientExport;
use App\Http\Livewire\User\Users;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ClientTable extends DataTableComponent
{
    use LivewireAlert;

    protected $model = Client::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Actions")
                ->label(fn ($row, Column $column) => view('pages.client.table.actions')->with(['client' => $row])),
            Column::make("Id", "id")
                ->collapseOnTablet()
                ->sortable(),
            Column::make("Name", "name")
                ->collapseOnTablet()
                ->searchable()
                ->sortable(),
            Column::make('Account Owner', 'users.name')
                ->collapseOnTablet()
                ->searchable()
                ->sortable(),
            Column::make("Company Email", "email")
                ->collapseOnTablet()
                ->searchable()
                ->sortable(),
            Column::make("Address", "address")
                ->collapseOnTablet()
                ->searchable()
                ->sortable(),
            Column::make("Phone number", "phone_number")
                ->collapseOnTablet()
                ->searchable()
                ->sortable(),
            // Column::make("Status", "status")
            //     ->sortable(),
            Column::make('Status', 'status')
                ->format(
                    fn ($value, $row, Column $column) => view('pages.client.table.status')->withValue($value)
                ),
        ];
    }

    public function builder(): Builder
    {
        $team = Auth::user()->currentTeam;
        $data = [];
        foreach ($team->users as $user) {
            $data[] = $user->id;
        }

        return Client::whereIn('user_id', $data);
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
        $clients = $this->getSelected();
        $total = count($clients);

        if ($total > 0) {
            $this->clearSelected();
            $currentDate = Carbon::now()->format('d-F-Y');
            return Excel::download(new ClientExport($clients), 'Client Data_' . $currentDate . '.xlsx');
        }

        $this->alert('warning', 'You did not select any clients to export.', ['timerProgressBar' => true,]);
    }

    public function exportCSV()
    {
        $clients = $this->getSelected();
        $total = count($clients);

        if ($total > 0) {
            $this->clearSelected();
            $currentDate = Carbon::now()->format('d-F-Y');
            return Excel::download(new ClientExport($clients), 'Clients Data_' . $currentDate . '.CSV', \Maatwebsite\Excel\Excel::CSV);
        }
        
        $this->alert('warning', 'You did not select any clients to export.', ['timerProgressBar' => true,]);
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

    public function delete(User $users)
    {
        $user_id = Client::where('id', $this->deleteId)->first()->user_id;
        $users->where('id', $user_id)->update(['client_id' => 0]);
        Client::find($this->deleteId)->delete();
        
        return $this->alert('success', 'Data has been deleted succesfully!', ['timerProgressBar' => true,]);
    }
}
