<div class="row">
    <div class="col-12 col-md-6 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4>Team - {{$team->name}}<h4>
            </div>
            <div class="card-body">
                <div class="row media">
                    <div class="col-12 mb-4">
                        <div class="media-title">Product Owner</div>
                        @forelse($po as $user)
                        <figure class="avatar mr-2 mt-2">
                            <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" data-toggle="tooltip" title="{{ $user->name }}">
                        </figure>
                        @empty
                        <p class="mb-4">Team has no product owner</p>
                        @endforelse
                    </div>
                </div>
                <div class="row media">
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="media-title">Project Manager</div>
                        @forelse($pm as $user)
                        @if($user->hasTeamRole($team, 'project-manager') || $user->ownsTeam($team))
                        <figure class="avatar mr-2 mt-2">
                            <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" data-toggle="tooltip" title="{{ $user->name }}">
                        </figure>
                        @endif
                        @empty
                        <p class="mb-4">Team has no project manager</p>
                        @endforelse
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="media-title">Assigned Team</div>
                        @forelse($tm as $user)
                        <figure class="avatar mr-2 mt-2">
                            <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" data-toggle="tooltip" title="{{ $user->name }}">
                        </figure>
                        @empty
                        <p class="mb-4">Team has no member</p>
                        @endforelse
                    </div>
                </div>

                <hr class="mb-4">

                <div class="row media">
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="media-title">Start Date</div>
                        <p>{{ $project->start_date }}</p>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="media-title">Due Date</div>
                        <p>{{ $project->end_date }}</p>
                    </div>
                </div>

                <div class="row media">
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="media-title">Category</div>
                        @if($project->category == "0")
                        <p>Web Development</p>
                        @elseif($project->category == "1")
                        <p>Mobile App Development</p>
                        @elseif($project->category == "2")
                        <p>Graphic Design</p>
                        @elseif($project->category == "3")
                        <p>Content Marketing</p>
                        @elseif($project->category == "4")
                        <p>Other</p>
                        @endif
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="media-title">Status</div>
                        @if($project->status == "0")
                        <div class="badge badge-secondary">Waiting Approval</div>
                        @elseif($project->status == "1")
                        <div class="badge badge-danger">Rejected</div>
                        @elseif($project->status == "2")
                        <div class="badge badge-info">In Progress</div>
                        @elseif($project->status == "3")
                        <div class="badge badge-success">Completed</div>
                        @elseif($project->status == "4")
                        <div class="badge badge-warning">On Hold</div>
                        @elseif($project->status == "5")
                        <div class="badge badge-danger">Cancelled</div>
                        @endif
                    </div>
                </div>

                <hr class="mb-4">

                <div class="media">
                    <div class="media-title">Platform</div>
                </div>
                <div class="form-group mt-2 mb-0">
                    <div class="selectgroup w-100">
                        <label class="selectgroup-item" data-toggle="tooltip" title="Default">
                            <input type="radio" @if($project->platform == "0") checked="checked" @endif class="selectgroup-input" disabled>
                            <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-laptop-code"></i></span>
                        </label>
                        <label class="selectgroup-item" data-toggle="tooltip" title="Web">
                            <input type="radio" @if($project->platform == "1") checked="checked" @endif class="selectgroup-input" disabled>
                            <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-globe"></i></span>
                        </label>
                        <label class="selectgroup-item" data-toggle="tooltip" title="Mobile">
                            <input type="radio" @if($project->platform == "2") checked="checked" @endif class="selectgroup-input" disabled>
                            <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-mobile"></i></span>
                        </label>
                        <label class="selectgroup-item" data-toggle="tooltip" title="Other">
                            <input type="radio" @if($project->platform == "3") checked="checked" @endif class="selectgroup-input" disabled>
                            <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-unlink"></i></span>
                        </label>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4>
                    Progress
                    @if($project->status == "2")
                        @if($date_now < $due_date) 
                            <span class="badge badge-info ml-2">{{$date_diff}} days left</span>
                        @else
                            <span class="badge badge-danger ml-2">{{$date_diff}} days late</span>
                        @endif
                    @endif
                <h4>
            </div>
            <div class="card-body">
                <ul class="list-unstyled user-progress list-unstyled-border list-unstyled-noborder pt-1 pb-2">
                    <li class="media">
                        <div class="media-body">
                            <div class="media-title mb-0 pt-0 pb-0">{{$project->title}}</div>
                            <div class="text-job text-muted">{{ $client->name }}</div>
                        </div>
                        <div class="media-progressbar">
                            <div class="progress-text">{{$project->progress}}%</div>
                            <div class="progress" data-height="6" style="height: 6px;" data-toggle="tooltip" title="{{ $project->progress }}%">
                                <div class="progress-bar bg-primary" data-width="{{ $project->progress }}%" aria-valuenow="{{ $project->progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="media-cta">
                            @php $current_team = Auth::user()->currentTeam; @endphp
                            @if(Auth::user()->hasTeamRole($current_team, 'project-manager'))
                            <a href="{{ route('project.edit', $project->id) }}" class="btn btn-icon icon-left btn-outline-primary mt-2" type="button"><i class="fas fa-edit"></i>Update Progress</a>
                            @endif
                        </div>
                    </li>
                </ul>

                <hr class="mb-4">

                <ul class="list-unstyled user-progress list-unstyled-border list-unstyled-noborder pt-1 pb-2">
                    <li class="media">
                        <div class="media-body">
                            <div class="media-title mb-0 pt-0 pb-0">Budget</div>
                            <div class="text-job text-muted">Project Budget</div>
                        </div>
                        <div class="media-progressbar">
                            @php
                                if($project->budget != 0){
                                    $percentage = ($spending / $project->budget)*100;
                                } else {
                                    $percentage = 0;
                                }
                               
                            @endphp
                            <div class="progress-text">${{ number_format($spending) }} of ${{ number_format($project->budget) }} Used</div>
                            <div class="progress" data-height="6" style="height: 6px;" data-toggle="tooltip" title="{{ $percentage }}%">
                                <div class="progress-bar
                                    @if($percentage > 100)
                                        bg-danger
                                    @elseif($percentage > 80 && $percentage <= 100)
                                        bg-warning
                                    @else 
                                        bg-primary
                                    @endif"
                                        data-width="{{ $percentage }}%" aria-valuenow="{{ $percentage }}" aria-valuemin="0"></div>
                            </div>
                            @if($percentage > 100)
                                <div class="progress-text"><span class="text-red-600">Budget Overused</span> </div>
                            @elseif($percentage > 80 && $percentage <= 100)
                                <div class="progress-text"><span style="color: #ffa426">More than 80% of budget used</span> </div>
                            @endif
                        </div>
                        <div class="media-cta">
                            @php $current_team = Auth::user()->currentTeam; @endphp
                            @if(Auth::user()->hasTeamRole($current_team, 'project-manager'))
                            <a href="{{ route('project.budget.manage', $project->id) }}" class="btn btn-icon icon-left btn-outline-primary mt-2" type="button"><i class="fas fa-edit"></i>Manage Budget</a>
                            @endif
                        </div>
                    </li>
                </ul>

                <hr class="mb-4">

                <ul class="list-unstyled user-progress list-unstyled-border list-unstyled-noborder pt-1 pb-2">
                    <li class="media">
                        <div class="media-body">
                            <div class="media-title mb-0 pt-0 pb-0">Total Task</div>
                            <div class="text-muted">{{ count($task->where('status', 1)) }} / {{ count($task) }} Done</div>
                        </div>
                        <div class="media-progressbar">
                            <div class="media-title mb-0 pt-0 pb-0">Time Spent</div>
                            <div class="text-muted">{{ $time_spent }}</div>
                        </div>
                        <div class="media-cta">
                            @if(Auth::user()->hasTeamRole($team, 'client-user'))
                            <a href="{{ route('project.task.gantt', $project->id) }}" class="btn btn-outline-primary mt-2"><i class="fas fa-tasks"></i> Task List</a>
                            @else
                            <a href="{{ route('project.task', $project->id) }}" class="btn btn-outline-primary mt-2"><i class="fas fa-tasks"></i> Task List</a>
                            @endif
                        </div>
                    </li>
                </ul>

                <hr class="mb-4">

                <ul class="list-unstyled user-progress list-unstyled-border list-unstyled-noborder pt-1 pb-2">
                    <li class="media">
                        <div class="media-body">
                            <div class="media-title mb-0 pt-0 pb-0">Report</div>
                            <div class="text-muted">Sprints and Timesheets Report</div>
                        </div>
                        <div class="media-cta">
                            <button class="btn btn-outline-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-chart-bar"></i>&nbsp; Reports
                            </button>
                            <div class="dropdown-menu" style="width: auto">
                                <a class="dropdown-item has-icon" href="{{ route('project.report.sprint', $project->id) }}"><i class="fas fa-file-alt"></i>Sprints</a>
                                <a class="dropdown-item has-icon" href="{{ route('project.report.timesheet', $project->id) }}"><i class="fas fa-clock"></i>Timesheets</a>
                            </div>
                        </div>
                    </li>
                </ul>

                <hr class="mb-4">

                <ul class="list-unstyled user-progress list-unstyled-border list-unstyled-noborder pt-1 pb-2">
                    <li class="media">
                        <div class="media-body">
                            <div class="media-title mb-0 pt-0 pb-0">Proposal</div>
                            <div class="text-muted">{{ $project->proposal }}</div>
                        </div>
                        <div class="media-cta">
                            <button class="btn btn-outline-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-file"></i>&nbsp; Actions
                            </button>
                            <div class="dropdown-menu" style="width: auto">
                                <a href="{{ route('project.proposal', $project->id) }}" class="dropdown-item has-icon" type="button"><i class="fas fa-download"></i>Download File</a>
                                <a href="" class="dropdown-item has-icon" data-toggle="modal" data-target="#proposalModal"><i class="fas fa-eye"></i> View File</a>
                            </div>
                        </div>
                    </li>
                </ul>


            </div>
        </div>
    </div>
</div>