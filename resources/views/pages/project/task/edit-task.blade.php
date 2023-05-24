<x-app-layout>
    <x-slot name="title">{{ __('Edit Task') }} - {{ $projects->title }}</x-slot>
    <x-slot name="header_content">
        <div class="section-header-back">
            <a href="{{ url()->previous() }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ __('Edit Task') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('project.index') }}">Project</a></div>
            <div class="breadcrumb-item active"><a href="../{{ $projects->id }}">#{{ $projects->id }}</a></div>
            <div class="breadcrumb-item">Edit Task</div>
        </div>
    </x-slot>

    <h2 class="section-title">Edit Task </h2>
    <p class="section-lead mb-3">
        On this page you can edit existing task data.
    </p>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-pills">
                        <li class="nav-item mr-2">
                            <a class="nav-link" href="/project/{{$projects->id}}/tasks"><i class="fas fa-chalkboard"></i> Kanban View</a>
                        </li>
                        <li class="nav-item mr-2">
                            <a class="nav-link" href="#"><i class="fas fa-table"></i> Table View</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/project/{{$projects->id}}/gantt-chart"><i class="fas fa-project-diagram"></i> Gantt Chart</a>
                        </li>
                        <li class="nav-item mr-2">
                            <a class="nav-link" href="/project/{{$projects->id}}/create-board"><i class="fas fa-plus"></i> New Board</a>
                        </li>
                        <li class="nav-item mr-2">
                            <a class="nav-link" href="/project/{{$projects->id}}/create-task"><i class="fas fa-plus"></i> New Task</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">

                    <form action="/project/{{$projects->id}}/tasks/{{$task->id}}/update-task" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Project</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="hidden" value="{{$projects->id}}" name="project_id">
                                <input type="hidden" value="{{$task->id}}" name="task_id">
                                <input class="form-control" readonly value="{{$projects->title}}">
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Title</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" name="title" value="{{ $task->title }}">
                                @error('title') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Backlog</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control select2" name="backlog_id">
                                    <option selected disabled> Select Backlog </option>
                                    @foreach ($backlogs as $backlog)
                                    <option value="{{ $backlog->id }}" @if($task->backlog_id == "$backlog->id") selected="selected" @endif>{{ $backlog->name }}</option>
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
                                    <option value="{{ $board->id }}" @if($task->board_id == "$board->id") selected="selected" @endif>{{ $board->title }}</option>
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
                                    <option value="{{ $sprint->id }}" @if($task->sprint_id == "$sprint->id") selected="selected" @endif>Sprint - {{ $sprint->name }}</option>
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
                                        <option value="{{ $user->id }}" 
                                            @foreach($assignee as $asn) 
                                                {{ $asn == $user->id ? 'selected': ''}}
                                            @endforeach
                                        >{{ $user->name }}</option>
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
                                    <option value="0" @if($task->priority == "0") selected="selected" @endif>Normal</option>
                                    <option value="1" @if($task->priority == "1") selected="selected" @endif>High</option>
                                    <option value="2" @if($task->priority == "2") selected="selected" @endif>Urgent</option>
                                    <option value="3" @if($task->priority == "3") selected="selected" @endif>Low</option>
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
                                    <input type="text" class="form-control daterange" name="task_date" value="{{ $dates }}">
                                </div>
                                @error('task_date') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-1">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Description</label>
                            <div class="col-sm-12 col-md-7">
                                <textarea class="summernote-simple" name="description">{{ $task->description }}</textarea>
                                @error('description') <span class="text-red-500 mb-4">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <button type="submit" class="btn btn-primary">Update Data</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
