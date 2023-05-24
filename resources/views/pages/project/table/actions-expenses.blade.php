@php
    $team = Auth::user()->currentTeam;
    $user = Auth::user();
    $expense = DB::table('expenses')->find($value);
@endphp
@if($user->ownsTeam($team) || $user->hasTeamRole($team, 'project-manager'))
<div class="dropdown">
    <a href="#" data-toggle="dropdown" class="btn btn-outline-dark dropdown-toggle">Options</a>
    <div class="dropdown-menu">
        <a href="{{ route('project.expenses.status.edit', ['id'=>$this->project, 'expense'=>$value]) }}" class="dropdown-item has-icon"><i class="fas fa-sync-alt"></i> Update Status</a>
        <a href="{{ route('project.expenses.edit', ['id'=>$this->project, 'expense'=>$value]) }}" class="dropdown-item has-icon"><i class="far fa-edit"></i> Edit Expenses</a>
        <div class="dropdown-divider"></div>     
        <a role="button" wire:click="deleteConfirm({{ $value }})" class="dropdown-item has-icon text-danger"><i class="far fa-trash-alt"></i> Delete</a>
    </div>
</div>
@elseif($user->hasTeamRole($team, 'team-member') || $user->hasTeamRole($team, 'client-user'))
<div class="dropdown">
    <a href="#" data-toggle="dropdown" class="btn btn-outline-dark dropdown-toggle">Options</a>
    <div class="dropdown-menu">
        @if($expense->expenses_status == 0 || $expense->expenses_status == 2)
        <a href="{{ route('project.expenses.edit', ['id'=>$this->project, 'expense'=>$value]) }}" class="dropdown-item has-icon"><i class="far fa-edit"></i> Edit Expenses</a>
        @else
        <a role="button" class="dropdown-item has-icon text-secondary" data-toggle="tooltip" title="Action is disabled for this expenses."><i class="far fa-edit"></i> Disabled</a>
        @endif
    </div>
</div>
@endif