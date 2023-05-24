@php
$task = DB::table('tasks')->where('backlog_id', $backlog->id)->get();
@endphp

<div class="dropdown">
    <a href="#" data-toggle="dropdown" class="btn btn-outline-dark dropdown-toggle">Options</a>
    <div class="dropdown-menu">
        <a href="/backlog/{{ $backlog->id }}/edit" class="dropdown-item has-icon"><i class="far fa-edit"></i> Edit</a>
        <div class="dropdown-divider"></div>

        @if(!empty($task->first()))
        <a role="button" class="dropdown-item has-icon text-secondary" data-toggle="tooltip" title="Action is disabled for this backlog."><i class="far fa-trash-alt"></i> Disabled</a>
        @else
        <a role="button" wire:click="deleteConfirm({{ $backlog->id }})" class="dropdown-item has-icon text-danger"><i class="far fa-trash-alt"></i> Delete</a>
        @endif
    </div>
</div>