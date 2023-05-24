<x-app-layout>
    <x-slot name="title">{{ __('Create Task') }} - {{ $projects->title }}</x-slot>
    <x-slot name="header_content">
        <div class="section-header-back">
            <a href="{{ url()->previous() }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ __('Add Task') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('project.index') }}">Project</a></div>
            <div class="breadcrumb-item active"><a href="../{{ $projects->id }}">#{{ $projects->id }}</a></div>
            <div class="breadcrumb-item">Create Task</div>
        </div>
    </x-slot>

    <h2 class="section-title">Create New </h2>
    <p class="section-lead mb-3">
        On this page you can create a new task data.
    </p>

    @php
        $team = Auth::user()->currentTeam;
    @endphp

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-pills">       
                        @if(Auth::user()->hasTeamPermission($team, 'create:task-board'))
                        <li class="nav-item">
                            <a class="nav-link" href="/project/{{$projects->id}}/tasks"><i class="fas fa-chalkboard"></i> Kanban View</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/project/{{$projects->id}}/table-view"><i class="fas fa-table"></i> Table View</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/project/{{$projects->id}}/gantt-chart"><i class="fas fa-project-diagram"></i> Gantt Chart</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/project/{{$projects->id}}/create-board"><i class="fas fa-plus"></i> New Board</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#"><i class="fas fa-plus"></i> New Task</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('project.task.finished', $projects->id) }}"><i class="fas fa-clipboard-check"></i> Finished Task</a>
                        </li>
                        @else
                        <li class="nav-item">
                            <a class="nav-link" href="/project/{{$projects->id}}/tasks"><i class="fas fa-chalkboard"></i> Kanban View</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/project/{{$projects->id}}/table-view"><i class="fas fa-table"></i> Table View</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('project.task.finished', $projects->id) }}"><i class="fas fa-clipboard-check"></i> Finished Task</a>
                        </li>
                        @endif
                    </ul>
                </div>
                <div class="card-body">

                    <form action="/project/store-task" method="post">
                        @csrf

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Project</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="hidden" value="{{$projects->id}}" name="project_id">
                                <input class="form-control" readonly value="{{$projects->title}}">
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Title</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                                @error('title') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Backlog</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control select2" name="backlog_id">
                                    <option selected disabled> Select Backlog </option>
                                    @foreach ($backlogs as $backlog)
                                    <option value="{{ $backlog->id }}">{{ $backlog->name }}</option>
                                    @endforeach
                                </select>
                                @error('backlog_id') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Board</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control select2" name="board_id">
                                    <option selected disabled> Select Board </option>
                                    @foreach ($boards as $board)
                                    <option value="{{ $board->id }}">{{ $board->title }}</option>
                                    @endforeach
                                </select>
                                @error('board_id') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Sprint</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control select2" name="sprint_id">
                                    <option selected disabled> Select Sprint </option>
                                    @foreach ($sprints as $sprint)
                                        @if($sprint->status == "1")
                                        <option disabled value="{{ $sprint->id }}" style="color:red">Sprint - {{ $sprint->name }} [CLOSED]</option>
                                        @else
                                        <option value="{{ $sprint->id }}">Sprint - {{ $sprint->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('sprint_id') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Assigned User</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control select2" name="assignee[]" multiple="">
                                    @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('assignee') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Priority</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control select2" name="priority">
                                    <option selected disabled> Select Priority </option>
                                    <option value="0">Normal</option>
                                    <option value="1">High</option>
                                    <option value="2">Urgent</option>
                                    <option value="3">Low</option>
                                </select>
                                @error('priority') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Start - End Date</label>
                            <div class="col-sm-12 col-md-7">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control daterange" name="task_date" value="{{ old('task_date') }}">
                                </div>
                                @error('task_date') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-1">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Description</label>
                            <div class="col-sm-12 col-md-7">
                                <textarea class="summernote-simple" name="description">{{ old('description') }}</textarea>
                                @error('description') <span class="text-red-500 mb-4">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <input type="hidden" name="from_mail" value="{{ Auth::user()->email }}">
                        <input type="hidden" name="mail_sender" value="{{ Auth::user()->name }}">
                        
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <button type="submit" class="btn btn-primary">Create Data</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
