@php
$team = Auth::user()->currentTeam;
$user = App\Models\User::where('id', $value)->first();
@endphp

@if($user->ownsTeam($team) || $user->hasTeamRole($team, 'project-manager'))
<div class="btn btn-primary btn-icon icon-left" style="width:145px">
    <i class="fas fa-wrench"></i> Project Manager
</div>
@elseif($user->hasTeamRole($team, 'client-user'))
<div class="btn btn-primary btn-icon icon-left" style="width:145px">
    <i class="fas fa-briefcase"></i> Client
</div>
@elseif($user->hasTeamRole($team, 'team-member'))
<div class="btn btn-primary btn-icon icon-left" style="width:145px">
    <i class="fas fa-users"></i> Team Member
</div>
@elseif($user->hasTeamRole($team, 'guest'))
<div class="btn btn-primary btn-icon icon-left" style="width:145px">
    <i class="fas fa-user"></i> Guest
</div>
@endif

