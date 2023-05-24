@php
$backlog = DB::table('backlogs')->where('sprint_id',  $sprint->id)->get();
$task = DB::table('tasks')->where('sprint_id',  $sprint->id)->get();
$sprint = DB::table('sprints')->where('id',  $sprint->id)->first();
@endphp

<div class="dropdown">
    <a href="#" data-toggle="dropdown" class="btn btn-outline-dark dropdown-toggle">Options</a>
    <div class="dropdown-menu">
        <a href="/sprint/{{ $sprint->id }}/edit" class="dropdown-item has-icon"><i class="far fa-edit"></i> Edit</a>
        <div class="dropdown-divider"></div>
        
        @if(!empty($backlog->first()) || !empty($task->first()))
        <a role="button" class="dropdown-item has-icon text-secondary" data-toggle="tooltip" title="Action is disabled for this sprint."><i class="far fa-trash-alt"></i> Disabled</a>
        @else
        <a role="button" wire:click="deleteConfirm({{ $sprint->id }})" class="dropdown-item has-icon text-danger"><i class="far fa-trash-alt"></i> Delete</a>
        @endif
    </div>
</div>