@php
$team = Auth::user()->currentTeam;
@endphp

<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
                <i class="fas fa-th-list"></i>
            </div>
            <div class="card-wrap" id="project-all">
                <div class="card-header">
                    <h4>All</h4>
                </div>
                <div class="card-body">
                    {{ DB::table('projects')->where('team_id', Auth::user()->currentTeam->id)->count() }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-info">
                <i class="fas fa-spinner"></i>
            </div>
            <div class="card-wrap" id="project-in-progress">
                <div class="card-header">
                    <h4>In Progress</h4>
                </div>
                <div class="card-body">
                    {{ DB::table('projects')->where('team_id', Auth::user()->currentTeam->id)->where('status', '2')->count() }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
                <i class="fas fa-hand-paper"></i>
            </div>
            <div class="card-wrap" id="project-on-hold">
                <div class="card-header">
                    <h4>On Hold</h4>
                </div>
                <div class="card-body">
                    {{ DB::table('projects')->where('team_id', Auth::user()->currentTeam->id)->where('status', '4')->count() }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-success">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="card-wrap" id="project-completed">
                <div class="card-header">
                    <h4>Completed</h4>
                </div>
                <div class="card-body">
                    {{ DB::table('projects')->where('team_id', Auth::user()->currentTeam->id)->where('status', '3')->count() }}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-header-action">
                    @if(Auth::user()->ownsTeam($team))
                    <a href="{{ route('project.create') }}" class="btn btn-icon icon-left btn-outline-dark" id="add-project"><i class="fas fa-plus"></i> Add Data</a>
                    @elseif(Auth::user()->hasTeamRole($team, 'client-user') || Auth::user()->hasTeamRole($team, 'team-member'))
                    <h4>My Projects</h4>
                    @endif
                </div>
            </div>
            <div class="card-body" id="project-table">
                <livewire:project.project-table/>
            </div>
        </div>
    </div>
</div>