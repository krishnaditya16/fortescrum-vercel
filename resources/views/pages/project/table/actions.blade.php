@php
$current_team = Auth::user()->currentTeam;
$backlog = DB::table('backlogs')->where('project_id', $project->id)->get();
$sprint = DB::table('sprints')->where('project_id', $project->id)->get();
$task = DB::table('tasks')->where('project_id', $project->id)->get();
@endphp

@if(Auth::user()->ownsTeam($current_team) || Auth::user()->hasTeamRole($current_team, 'project-manager')) 
<div class="dropdown">
    <a href="#" data-toggle="dropdown" class="btn btn-outline-dark dropdown-toggle">Options</a>
    <div class="dropdown-menu">
        <a href="/project/{{ $project->id }}/" class="dropdown-item has-icon"><i class="fas fa-external-link-alt"></i> View</a>
        <a href="/project/{{ $project->id }}/edit" class="dropdown-item has-icon"><i class="far fa-edit"></i> Edit</a>
        <a href="/project/{{ $project->id }}/tasks" class="dropdown-item has-icon"><i class="fas fa-tasks"></i> Task List </a>
        <div class="dropdown-divider"></div>
        @if(!empty($backlog->first()) || !empty($sprint->first()) || !empty($task->first()))
        <a role="button" class="dropdown-item has-icon text-secondary" data-toggle="tooltip" title="There still some backlog/sprint/task attached to this project."><i class="far fa-trash-alt"></i> Disabled</a>
        @else
        <a role="button" wire:click="deleteConfirm({{ $project->id }})" class="dropdown-item has-icon text-danger"><i class="far fa-trash-alt"></i> Delete</a>
        @endif
    </div>
</div>
@elseif(Auth::user()->hasTeamRole($current_team, 'team-member'))
<div class="dropdown">
    <a href="#" data-toggle="dropdown" class="btn btn-outline-dark dropdown-toggle">Options</a>
    <div class="dropdown-menu">
        <a href="/project/{{ $project->id }}/" class="dropdown-item has-icon"><i class="fas fa-external-link-alt"></i> View</a>
        <a href="/project/{{ $project->id }}/tasks" class="dropdown-item has-icon"><i class="fas fa-tasks"></i> Task List </a>
    </div>
</div>
@elseif(Auth::user()->hasTeamRole($current_team, 'client-user'))
<div class="dropdown">
    <a href="#" data-toggle="dropdown" class="btn btn-outline-dark dropdown-toggle">Options</a>
    <div class="dropdown-menu">
        <a href="/project/{{ $project->id }}/" class="dropdown-item has-icon"><i class="fas fa-external-link-alt"></i> View</a>
        <a href="{{ route('project.status', $project->id) }}" class="dropdown-item has-icon"><i class="fas fa-vote-yea"></i> Project Approval</a>
    </div>
</div>
@endif