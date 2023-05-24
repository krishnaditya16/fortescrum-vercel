<?php

namespace App\Http\Livewire\Client;

use App\Exports\ClientUserExport;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use App\Models\Client;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Maatwebsite\Excel\Facades\Excel;

class ClientUserTable extends DataTableComponent
{
    use LivewireAlert;

    protected $model = Client::class;

    public function configure(): void
    {
        $this->setPrimaryKey('users.id');
    }

    public function columns(): array
    {
        return [
            Column::make("Actions", "users.id")
                ->format(
                    fn ($value, $row, Column $column) => view('pages.client.table.user-actions')->withValue($value)
                ),
            // Column::make("Actions", "users.id")
            //     ->label(fn ($row, Column $column) => view('pages.client.table.user-actions')->with(['user' => $row])),
            Column::make("User ID", "users.id")
                ->collapseOnTablet()
                ->sortable(),
            // Column::make("Name", "users.name")
            //     ->collapseOnTablet()
            //     ->searchable()
            //     ->sortable(),
            // Column::make("Email", "users.email")
            //     ->collapseOnTablet()
            //     ->searchable()
            //     ->sortable(),
            Column::make("User", "users.id as user_id")
                ->searchable(function ($builder, $term) {
                    return $builder->orWhereHas('users', function($query) use($term){
                        $query->where('name', 'LIKE', '%' . $term . '%')->orWhere('email', 'LIKE', '%' . $term . '%');
                    });
                })
                ->format(
                    fn ($value, $row, Column $column) => view('pages.client.table.client-users')->with(['client' => $row])
                ),
            Column::make("Client", "name")
                ->collapseOnTablet()
                ->searchable()
                ->sortable(),
            BooleanColumn::make('Verified', 'users.email_verified_at')
                ->sortable()
                ->collapseOnTablet(),
            BooleanColumn::make('2FA', 'users.two_factor_secret')
                ->sortable()
                ->collapseOnTablet(),
        ];
    }

    public function builder(): Builder
    {
        $team = Auth::user()->currentTeam;
        $data = [];
        foreach ($team->users as $user) {
            if($user->hasTeamRole($team, 'client-user')){
                $data[] = $user->id;
            }
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
            return Excel::download(new ClientUserExport($clients), 'Client\'s Account Data_' . $currentDate . '.xlsx');
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
            return Excel::download(new ClientUserExport($clients), 'Client\'s Account Data_' . $currentDate . '.CSV', \Maatwebsite\Excel\Excel::CSV);
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

    public function delete()
    {
        User::find($this->deleteId)->delete();
        return $this->alert('success', 'Data has been deleted succesfully!', ['timerProgressBar' => true,]);
    }
}
