<?php

namespace App\Http\Livewire\Notification;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;

class NotificationTable extends DataTableComponent
{
    protected $model = Notification::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Detail", "detail")
                ->searchable()
                ->sortable(),
            BooleanColumn::make("Read", "read_at")
                ->searchable()
                ->sortable(),
            Column::make("Created at", "created_at")
                ->searchable()
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->searchable()
                ->sortable(),
        ];
    }

    public function builder(): Builder
    {
        $user = Auth::user()->id;
        return Notification::where('user_id', $user);
    }
}
