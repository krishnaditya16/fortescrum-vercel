<?php

namespace App\Http\Livewire\User;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;
use App\Exports\UserExport;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;

class UserTable extends DataTableComponent
{
    use LivewireAlert;

    protected $model = User::class;
    
    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Actions")
                ->label(fn ($row, Column $column) => view('pages.user.table.actions')->with(['user' => $row])),
            Column::make("Id", "id")
                ->collapseOnTablet()
                ->sortable(),
            Column::make('Profile Photo', 'profile_photo_path')
                ->format(
                    fn ($value, $row, Column $column) => view('pages.user.table.photo')->withValue($row)
                ),
            Column::make("Name", "name")
                ->collapseOnTablet()
                ->searchable()
                ->sortable(),
            Column::make("Email", "email")
                ->collapseOnTablet()
                ->searchable()
                ->sortable(),
            BooleanColumn::make('Verified', 'email_verified_at')
                ->sortable()
                ->collapseOnTablet(),
            BooleanColumn::make('2FA', 'two_factor_secret')
                ->sortable()
                ->collapseOnTablet(),
            // Column::make('Current Team', 'current_team_id')
            //     ->format(
            //         fn ($value, $row, Column $column) => view('pages.user.table.current_team')->withValue($value)
            //     ),
            Column::make('Role', 'id')
                ->format(
                    fn ($value, $row, Column $column) => view('pages.user.table.role')->withValue($value)
                ),
        ];
    }

    public function builder(): Builder
    {
        $team = Auth::user()->currentTeam;
        $data = [];
        foreach ($team->allUsers() as $user) {
            $data[] = $user->id;
        }

        return User::whereIn('id', $data);
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
        $users = $this->getSelected();
        $total = count($users);

        if ($total > 0) {
            $this->clearSelected();
            $currentDate = Carbon::now()->format('d-F-Y');
            return Excel::download(new UserExport($users), 'Users Data_' . $currentDate . '.xlsx');
        }

        $this->alert('warning', 'You did not select any users to export.', ['timerProgressBar' => true,]);
    }

    public function exportCSV()
    {
        $users = $this->getSelected();
        $total = count($users);

        if ($total > 0) {
            $this->clearSelected();
            $currentDate = Carbon::now()->format('d-F-Y');
            return Excel::download(new UserExport($users), 'Users Data_' . $currentDate . '.CSV', \Maatwebsite\Excel\Excel::CSV);
        }
        
        $this->alert('warning', 'You did not select any users to export.', ['timerProgressBar' => true,]);
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
