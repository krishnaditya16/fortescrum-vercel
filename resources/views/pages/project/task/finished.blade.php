<x-app-layout>
    <x-slot name="title">{{ $data->title }}</x-slot>
    <x-slot name="header_content">
        <div class="section-header-back">
            <a href="{{ route('project.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ $data->title }} - {{ __('Tasks Data') }}</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('project.index') }}">Project</a></div>
            <div class="breadcrumb-item active"><a href="../{{ $data->id }}">#{{ $data->id }}</a></div>
            <div class="breadcrumb-item">Task</div>
        </div>
    </x-slot>

    <h2 class="section-title">Tasks Kanban</h2>
    <p class="section-lead">
        You can manage & view tasks data using the kanban board below.
    </p>

    @php
        $team = Auth::user()->currentTeam;
    @endphp

    <div class="row mb-4 mt-2">
        <div class="col-12">
            <div class="card mb-0">
                <div class="card-body">
                    <ul class="nav nav-pills">
                        @if(Auth::user()->hasTeamPermission($team, 'create:task-board'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('project.task', $data->id) }}"><i class="fas fa-chalkboard"></i> Kanban View</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('project.task.table', $data->id) }}"><i class="fas fa-table"></i> Table View</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/project/{{$data->id}}/gantt-chart"><i class="fas fa-project-diagram"></i> Gantt Chart</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('project.board.create', $data->id) }}"><i class="fas fa-plus"></i> New Board</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('project.task.create', $data->id) }}"><i class="fas fa-plus"></i> New Task</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('project.task.finished', $data->id) }}"><i class="fas fa-clipboard-check"></i> Finished Task</a>
                        </li>
                        @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('project.task', $data->id) }}"><i class="fas fa-chalkboard"></i> Kanban View</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('project.task.table', $data->id) }}"><i class="fas fa-table"></i> Table View</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('project.task.finished', $data->id) }}"><i class="fas fa-clipboard-check"></i> Finished Task</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid kanban">
        <div class="row flex-row flex-nowrap">
            @forelse ($boards as $board)
            <div class="col-12 col-lg-3 kanban-list card card-primary">
                <div class="kanban-title dropleft"> {{ $board->title }} <span class="badge badge-primary ml-1">{{ count($board->tasks->where('status', 1)) }}</span>
                    @if(Auth::user()->ownsTeam($team) || Auth::user()->hasTeamRole($team, 'project-manager'))
                    <button class="btn float-right" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <i class="fas fa-ellipsis-v"></i></button>
                    <div class="dropdown-menu dropleft">
                        <a class="dropdown-item" href="/project/{{$data->id}}/tasks/edit-board/{{$board->id}}"><i class="fas fa-edit"></i>&nbsp; Edit Board</a>
                        @if(empty($board->tasks->first()))
                        <form action="{{ route('project.board.destroy', ['id'=>$data->id, 'board'=>$board->id]) }}" method="POST" id="deleteBoard">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="dropdown-item has-icon btn-outline-danger btn-dropdown-kanban" data-confirm="Are You Sure?|This board will be deleted. Do you want to continue?" data-confirm-yes="document.getElementById('deleteBoard').submit();">
                                <i class="fas fa-trash"></i> Delete Board
                            </button>
                        </form>
                        @else
                        <a class="dropdown-item" style="color:grey" data-toggle="tooltip" data-placement="bottom" title="Action is disabled for this board."><i class="fas fa-trash"></i>&nbsp; Delete Board</a>
                        @endif
                    </div>
                    @endif
                </div>
                
                @forelse($board->tasks->where('status', 1) as $task)
                
                <a href="" data-toggle="modal" data-target="#taskModal{{ $task->id }}" style="text-decoration: none;color:#6c757d;">
                    <div class="card" data-toggle="tootltip" title="Click to show detail!">
                        <div class="card-header">
                            <h4>{{ $task->title }}</h4>
                        </div>
                        <div class="card-body">
                            @if($task->priority == "0")
                            <div class="badge badge-info mb-2">Normal</div><br>
                            @elseif($task->priority == "1")
                            <div class="badge badge-warning mb-2">High</div><br>
                            @elseif($task->priority == "2")
                            <div class="badge badge-danger mb-2">Urgent</div><br>
                            @elseif($task->priority == "3")
                            <div class="badge badge-light mb-2">Low</div><br>
                            @endif
                            <b>Client:</b>
                            @php
                            $myArray = array();
                            foreach ($owner as $user){
                            $myArray[] = '<span>'.ucfirst($user->name).'</span>';
                            }
                            echo implode( ', ', $myArray ).'<br>';
                            @endphp
                            <b>Created:</b> {{date('d-m-Y', strtotime($task->created_at));}}<br>
                            <b>Due Date:</b> {{date('d-m-Y', strtotime($task->end_date));}}<br>
                        </div>
                </a>
                <div class="card-footer bg-whitesmoke">
                    <form action="{{ route('project.task.destroy', ['id'=>$data->id, 'task'=>$task->id]) }}" method="POST" style="display: inline-block;" id="deleteTask">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-outline-danger has-icon" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('deleteTask').submit();">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                    <form action="{{ route('project.task.status', ['id'=>$data->id, 'task'=>$task->id]) }}" method="POST" style="display: inline-block;" id="moveTask">
                        @csrf
                        @method('PUT')
                        <input type="hidden" value="0" name="status">
                        <input type="hidden" value="{{ $task->id }}" name="task_id">
                        <a href="#" class="btn btn-outline-primary has-icon" data-confirm="Are You Sure?|This task will be moved back to in progress kanban. Do you want to continue?" data-confirm-yes="document.getElementById('moveTask').submit();">
                            <i class="fas fa-angle-double-right"></i> Move Back
                        </a>
                    </form>
                    
                </div>
            </div>
            
            @empty
            <div class="alert empty-kanban alert-has-icon">
                <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                <div class="alert-body">
                    <div class="alert-title">Empty</div>
                    There is no task for this board.
                </div>
            </div>
            @endforelse
        </div>
        @empty
            <div class="card col-12">
                <div class="card-header">
                    <h4>Empty Board</h4>
                </div>
                <div class="card-body">
                    <div class="empty-state" data-height="400" style="height: 400px;">
                        <div class="empty-state-icon">
                            <i class="fas fa-question"></i>
                        </div>
                        <h2>We couldn't find any boards related to the project.</h2>
                        <p class="lead">
                            Sorry we can't find any data, to get rid of this message, make at least 1 entry.
                        </p>
                        <a href="/project/{{$data->id}}/create-board" class="btn btn-primary mt-4">Create new One</a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

</x-app-layout>

<!-- Modal -->
@foreach ($boards as $board)
@foreach($board->tasks as $task)
<div class="modal fade" id="taskModal{{$task->id}}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="taskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="taskModalLabel">{{$task->title}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <hr class="mb-6">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-8">
                        <h4 class="mb-4"><i class="fas fa-book"></i>&nbsp; Description</h4>
                        {!!$task->description!!}
                        <hr class="mb-4 mt-4">
                    </div>
                    <div class="col-12 col-md-4 col-lg-4">
                        <h4><i class="fas fa-users"></i>&nbsp; Assigned Users</h4>
                        @php
                        $arr = $task->assignee;
                        $assignee = explode(",",$arr);
                        $users = DB::table('users')->whereIn('id', $assignee)->get();
                        @endphp
                        @foreach ($users as $user)
                        @if(is_null($user->profile_photo_path))
                        @php
                        $name = trim(collect(explode(' ', $user->name))->map(function ($segment) {
                        return mb_substr($segment, 0, 1);
                        })->join(''));
                        @endphp
                        <figure class="avatar mr-2 mb-4 mt-2" data-initial="{{$name}}" data-toggle="tooltip" title="{{ $user->name }}"></figure>
                        @else
                        <figure class="avatar mr-2 mb-4 mt-2">
                            <img src="{{ asset('storage/'.$user->profile_photo_path) }}" alt="{{ $user->name }}" data-toggle="tooltip" title="{{ $user->name }}">
                        </figure>
                        @endif
                        @endforeach
                        <hr class="mb-4">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-6 mb-4">
                                <h4><i class="fas fa-folder"></i>&nbsp; Project</h4>
                                <a href="/project/{{$data->id}}">
                                    <p>{{ $data->title }}</p>
                                </a>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 mb-4">
                                <h4><i class="fas fa-shield-alt"></i> Priority</h4>
                                @if($task->priority == "0")
                                <div class="badge badge-info mt-1">Normal</div><br>
                                @elseif($task->priority == "1")
                                <div class="badge badge-warning mt-1">High</div><br>
                                @elseif($task->priority == "2")
                                <div class="badge badge-danger mt-1">Urgent</div><br>
                                @elseif($task->priority == "3")
                                <div class="badge badge-light mt-1">Low</div><br>
                                @endif
                            </div>
                        </div>
                        <div class="mb-4">
                            <h4><i class="fas fa-folder-open"></i>&nbsp; Sprint Iteration</h4>
                            @foreach ($sprints as $sprint)
                            @if($task->sprint_id == $sprint->id)
                            <p>Sprint - {{ $sprint->name }}</p>
                            @endif
                            @endforeach
                        </div>
                        <div class="mb-4">
                            <h4><i class="fas fa-flag"></i>&nbsp; Backlog</h4>
                            @foreach ($backlogs as $backlog)
                            @if($task->backlog_id == $backlog->id)
                            <p>{{ $backlog->name }}</p>
                            @endif
                            @endforeach
                        </div>
                        <div class="mb-4">
                            <h4><i class="fas fa-info-circle"></i>&nbsp; Status</h4>
                            @if($task->status == "0")
                            <div class="badge badge-secondary mt-1">In Progress</div><br>
                            @elseif($task->status== "1")
                            <div class="badge badge-success mt-1">Done</div><br>
                            @endif
                        </div>
                        <div class="mb-4">
                            <h4><i class="fas fa-calendar-check"></i> Done at</h4>
                            <p>{{ date("D, d M Y h:i A", strtotime($task->updated_at)) }}</p>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-6 mb-4">
                                <h4><i class="fas fa-calendar-plus"></i>&nbsp; Start Date</h4>
                                <p>{{ $task->start_date }}</p>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 mb-4">
                                <h4><i class="fas fa-calendar-times"></i>&nbsp; Due Date</h4>
                                <p>{{ $task->start_date }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                <a href="{{ route('project.task.progress', ['id' => $data->id, 'task' => $task->id]) }}" class="btn btn-icon icon-left btn-primary" type="button"><i class="fas fa-tasks"></i> View Progress</a>
            </div>
        </div>
    </div>
</div>
@endforeach
@endforeach