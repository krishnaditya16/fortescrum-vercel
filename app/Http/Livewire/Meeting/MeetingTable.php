<?php

namespace App\Http\Livewire\Meeting;

use App\Exports\MeetingProjectExport;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Database\Eloquent\Builder;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Meeting;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class MeetingTable extends DataTableComponent
{
    use LivewireAlert;

    protected $model = Meeting::class;

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
            Column::make("Actions")
                ->label(fn ($row, Column $column) => view('pages.meeting.table.actions-meeting')->with(['meeting' => $row])),
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Title", "title")
                ->searchable(),
            Column::make("Date", "meeting_date")
                ->searchable(),
            Column::make("From", "start_time")
                ->searchable(),
            Column::make("To", "end_time")
                ->searchable(),
            Column::make("Type", "type")
                ->searchable()
                ->format(
                    fn ($value, $row, Column $column) => view('pages.meeting.table.type')->with(['type' => $row])
                ),
        ];
    }

    public function builder(): Builder
    {
        return Meeting::where('project_id', $this->project)->orderBy('meeting_date', 'DESC');
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
        $meeting = $this->getSelected();
        $total = count($meeting);

        if ($total > 0) {
            $this->clearSelected();
            $currentDate = Carbon::now()->format('d-F-Y');
            return Excel::download(new MeetingProjectExport($meeting), 'Meeting Project Data_' . $currentDate . '.xlsx');
        }

        $this->alert('warning', 'You did not select any meeting data to export.', ['timerProgressBar' => true,]);
    }

    public function exportCSV()
    {
        $meeting = $this->getSelected();
        $total = count($meeting);

        if ($total > 0) {
            $this->clearSelected();
            $currentDate = Carbon::now()->format('d-F-Y');
            return Excel::download(new MeetingProjectExport($meeting), 'Meeting Project Data_' . $currentDate . '.CSV', \Maatwebsite\Excel\Excel::CSV);
        }
        
        $this->alert('warning', 'You did not select any meeting data to export.', ['timerProgressBar' => true,]);
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
        Meeting::find($this->deleteId)->delete();
        return $this->alert('success', 'Data has been deleted succesfully!', ['timerProgressBar' => true,]);
    }
}
