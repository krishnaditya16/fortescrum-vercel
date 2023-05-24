<x-app-layout>
    <x-slot name="title">{{ __('Dashboard') }}</x-slot>
    <x-slot name="header_content">
        <h1>Dashboard</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item">Home</div>
        </div>
    </x-slot>

    @if(empty(Auth::user()->two_factor_secret))
    <div class="row">
        <div class="col-12 mb-4" id="hero-dimiss">
                <div class="hero bg-primary text-white">
                    <div class="hero-inner">
                        <h2>Welcome, {{ Auth::user()->name }}! </h2> 
                        <p class="lead">It seems that you haven't activate the 2 factor verification feature, please setup 2FA to make your account more secured.</p>
                        <div class="mt-4">
                            <a href="{{ route('profile.show') }}" class="btn btn-outline-white btn-lg btn-icon icon-left mr-2"><i class="far fa-user"></i> Setup Account</a>
                            <a data-dismiss="#hero-dimiss" class="btn btn-outline-white btn-lg btn-icon icon-left" href="#"><i class="fas fa-times"></i> Close</a>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    @else
    <div class="row">
        <div class="col-12 mb-4" id="hero-dimiss">
            <div class="hero align-items-center bg-primary text-white">
                <div class="hero-inner text-center">
                  <h2>Welcome, {{ Auth::user()->name }}!</h2>
                  <p class="lead">You can manage your project and other resources using the tools avalaible in this app.</p>
                    <div class="mt-4">
                        <a data-dismiss="#hero-dimiss" class="btn btn-outline-white btn-lg btn-icon icon-left" href="#"><i class="fas fa-times"></i> Close</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @php
        $team = Auth::user()->currentTeam;
    @endphp

    @if(Auth::user()->hasTeamRole($team, 'guest') && !Auth::user()->ownsTeam($team))
    <div class="alert alert-primary alert-has-icon p-4">
        <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
        <div class="alert-body">
            <div class="alert-title">Guest User</div>
            <p>You're still a guest, ask project manager to invite you into their team!</p>
        </div>
    </div>
    @endif

    @if(Auth::user()->hasTeamRole($team, 'project-manager') || Auth::user()->hasTeamRole($team, 'client-user') || Auth::user()->hasTeamRole($team, 'team-member') || Auth::user()->ownsTeam($team))

    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="far fa-folder"></i>
                </div>
                <div class="card-wrap" id="total-project">
                    <div class="card-header">
                        <h4>Total Project</h4>
                    </div>
                    <div class="card-body">
                        {{ count(DB::table('projects')->where('team_id', Auth::user()->currentTeam->id)->get()) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                    <i class="fas fa-folder-open"></i>
                </div>
                <div class="card-wrap" id="total-sprint">
                    <div class="card-header">
                        <h4>Sprint</h4>
                    </div>
                    <div class="card-body">
                        {{ 
                            count(DB::table('sprints')
                                ->join('projects', 'sprints.project_id', 'projects.id')
                                ->where('projects.team_id', Auth::user()->currentTeam->id)
                                ->get()
                            )
                        }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="fas fa-flag"></i>
                </div>
                <div class="card-wrap" id="total-backlog">
                    <div class="card-header">
                        <h4>Backlog</h4>
                    </div>
                    <div class="card-body">
                        {{ 
                            count(DB::table('backlogs')
                                ->join('projects', 'backlogs.project_id', 'projects.id')
                                ->where('projects.team_id', Auth::user()->currentTeam->id)
                                ->get()
                            )
                        }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="card-wrap" id="total-task">
                    <div class="card-header">
                        <h4>Task</h4>
                    </div>
                    <div class="card-body">
                        {{ 
                            count(DB::table('tasks')
                                ->join('projects', 'tasks.project_id', 'projects.id')
                                ->where('projects.team_id', Auth::user()->currentTeam->id)
                                ->get()
                            )
                        }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        $team = Auth::user()->currentTeam;
        $users = $team->allUsers();
        $projects = DB::table('projects')->where('team_id', $team->id)->get();
        $tasks = DB::table('tasks')
            ->join('projects', 'tasks.project_id', 'projects.id')
            ->where('projects.team_id', $team->id)
            ->get([
                'projects.*', 
                'tasks.title as task_title', 
                'tasks.status as task_status',
                'tasks.end_date as task_end', 
                'tasks.project_id', 
                'tasks.assignee'
            ]);

        $now = Carbon\Carbon::now();
        $meetings = DB::table('meetings')
            ->join('projects', 'meetings.project_id', 'projects.id')
            ->where('projects.team_id', $team->id)
            ->whereBetween("meeting_date", [
                        $now->startOfWeek()->format('Y-m-d'), 
                        $now->endOfWeek()->format('Y-m-d')
                    ])->get();
    @endphp

    <div class="row">
        <div class="col-lg-6 col-md-6 col-12">
            <div class="card" style="max-height: 300px; overflow:auto" id="project-progress">
                <div class="card-header">
                    <h4>All Project Progress</h4>
                </div>

                <div class="card-body">

                @foreach($projects as $project)
                    <div class="mb-4">
                        <div class="text-small float-right font-weight-bold text-muted">{{ $project->progress }}%</div>
                        <div class="font-weight-bold mb-1" id="project-name">{{ $project->title }}</div>
                        <div class="progress" data-height="8" data-toggle="tooltip" title="{{ $project->progress }}%" id="project-current-progress">
                            <div class="progress-bar" role="progressbar" data-width="{{ $project->progress }}%" aria-valuenow="{{ $project->progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                @endforeach

                </div>
            </div>

            <div class="card" style="max-height: 550px; overflow:auto" id="project-meeting">
                <div class="card-header">
                    <h4>This Week Meetings</h4>
                </div>
                <div class="card-body">
                    <div class="summary">
                        <div class="summary-info">
                            <h4>Meeting</h4>
                            <div class="text-muted">{{ count($meetings) }} this week</div>
                            @if(!count($meetings) == 0)
                            <div class="d-block mt-2">
                                <a href="{{ route('meeting.index') }}">View All</a>
                            </div>
                            @endif
                        </div>
                        <div class="summary-item">
                            <h6>Item List <span class="text-muted">({{ count($meetings) }} Items)</span></h6>
                            <ul class="list-unstyled list-unstyled-border">
                                @forelse($meetings as $meeting)
                                <li class="media">
                                    <div class="media-body">
                                        <div class="media-right">{{ date('D, d M Y', strtotime($meeting->meeting_date)) }}</div>
                                        <div class="media-title"><a href="#">{{ $meeting->title }}</a></div>
                                        <div class="text-muted text-small">From : {{ date("h:i A", strtotime($meeting->start_time)) }}
                                            <div class="bullet"></div> To : {{ date("h:i A", strtotime($meeting->end_time)) }}
                                        </div>
                                        @if($meeting->type == 0)
                                        <div class="text-muted text-small">
                                            Location : {{ $meeting->meeting_location}}
                                        </div>
                                        @else
                                        <div class="text-muted text-small">
                                            Meeting URL : <a href="{{ $meeting->meeting_link }}">Link</a>
                                        </div>
                                        @endif
                                    </div>
                                </li>
                                @empty
                                <li class="media">
                                    <div class="media-body" style="text-align:center">
                                        There is no meeting for this week
                                    </div>
                                </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
        <div class="col-lg-6 col-md-6 col-12">

            <div class="card" style="max-height: 500px; overflow:auto" id="team-user">
                <div class="card-header">
                    <h4>Team - {{ Auth::user()->currentTeam->name }}</h4>
                </div>
                <div class="card-body">
                    <div class="row pb-2">
                        @foreach($users as $user)
                        @if($user->hasTeamRole($team, 'project-manager') || $user->ownsTeam($team))
                        <div class="col-6 col-sm-3 col-lg-3 mb-4 mt-2 mb-md-0">
                            <div class="avatar-item mb-0">
                                <img alt="image" src="{{ $user->profile_photo_url }}" class="img-fluid" data-toggle="tooltip" title="" data-original-title="{{ $user->name }}" style="width: 112.4px; height: 112.4px; object-fit: cover;">
                                <div class="avatar-badge" title="" data-toggle="tooltip" data-original-title="Project Manager"><i class="fas fa-wrench"></i></div>
                            </div>
                        </div>
                        @elseif($user->hasTeamRole($team, 'client-user'))
                        <div class="col-6 col-sm-3 col-lg-3 mb-4 mt-2 mb-md-0">
                            <div class="avatar-item mb-0">
                                <img alt="image" src="{{ $user->profile_photo_url }}" class="img-fluid" data-toggle="tooltip" title="" data-original-title="{{ $user->name }}" style="width: 112.4px; height: 112.4px; object-fit: cover;">
                                <div class="avatar-badge" title="" data-toggle="tooltip" data-original-title="Client"><i class="fas fa-briefcase"></i></div>
                            </div>
                        </div>
                        @elseif($user->hasTeamRole($team, 'team-member'))
                        <div class="col-6 col-sm-3 col-lg-3 mb-4 mt-2 mb-md-0">
                            <div class="avatar-item mb-0">
                                <img alt="image" src="{{ $user->profile_photo_url }}" class="img-fluid" data-toggle="tooltip" title="" data-original-title="{{ $user->name }}" style="width: 112.4px; height: 112.4px; object-fit: cover;">
                                <div class="avatar-badge" title="" data-toggle="tooltip" data-original-title="Team Member"><i class="fas fa-users"></i></div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card" style="max-height: 500px; overflow:auto" id="project-task">
                <div class="card-header">
                    <h4 class="d-inline">All Tasks</h4>
                    <div class="card-header-action dropdown" id="project-dropdown">
                        <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle" aria-expanded="false">Projects</a>
                        <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(75px, 31px, 0px);">
                            <li class="dropdown-title">Select Project</li>
                            @foreach($projects as $project)
                            <li><a href="{{ route('project.task', $project->id) }}" class="dropdown-item">{{ $project->title }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled list-unstyled-border">
                        @php $nowDate = Carbon\Carbon::now(); @endphp
                        @forelse($tasks->where('task_status', 0) as $task)
                        <li class="media">
                            <div class="media-body">
                                @if(!$nowDate->gt(Carbon\Carbon::parse($task->task_end)))
                                <div class="badge badge-pill badge-info mt-4 mb-1 float-right">In Progress</div>
                                @else
                                <div class="badge badge-pill badge-danger mt-4 mb-1 float-right">Overdue</div>
                                @endif
                                <h6 class="media-title"><a href="{{ route('project.task', $task->project_id) }}">{{ $task->task_title }}</a></h6>
                                <div class="text-small text-muted">
                                    @php
                                        $id_user = explode(",", $task->assignee); 
                                        $task_user = DB::table('users')->whereIn('id', $id_user)->get();
                                    @endphp
                                    <b>Assigned Users : </b>
                                    @foreach($task_user as $asn)
                                        {{ $asn->name }},
                                    @endforeach
                                </div>
                                <div class="text-small text-muted">
                                    <b>Due Date :</b> {{ date('D, d M Y', strtotime($task->task_end)) }}
                                </div>
                            </div>
                        </li>
                        @empty
                        <li class="media">
                            <div class="media-body" style="text-align:center">
                                There is no task
                            </div>
                        </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @endif

    @push('custom-scripts')
        <script src="{{ asset('stisla/js/shepherd/dashboard-tour.js') }}"></script>
    @endpush

</x-app-layout>