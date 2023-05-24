<x-app-layout>
    <x-slot name="title">{{ __('Record Timesheet') }} - {{ $projects->title }}</x-slot>
    <x-slot name="header_content">
        <div class="section-header-back">
            <a href="{{ url()->previous() }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ __('Record Timesheet') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('project.index') }}">Project</a></div>
            <div class="breadcrumb-item active"><a href="../{{ $projects->id }}">#{{ $projects->id }}</a></div>
            <div class="breadcrumb-item">Record Timesheet</div>
        </div>
    </x-slot>

    <h2 class="section-title">Record Timesheet </h2>
    <p class="section-lead mb-3">
        On this page you can record your work time on a certain task.
    </p>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link" href="/project/{{$projects->id}}/tasks"><i class="fas fa-chalkboard"></i> Kanban View</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/project/{{$projects->id}}/table-view"><i class="fas fa-table"></i> Table View</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/project/{{$projects->id}}/create-board"><i class="fas fa-plus"></i> New Board</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/project/{{$projects->id}}/create-task"><i class="fas fa-plus"></i> New Task</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('project.task.finished', $projects->id) }}"><i class="fas fa-clipboard-check"></i> Finished Task</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">

                    <form action="{{ route('project.timesheet.store') }}" method="post">
                        @csrf

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Project</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="hidden" value="{{ $projects->id }}" name="project_id">
                                <input type="hidden" value="{{ Auth::user()->id }}" name="user_id">
                                <input class="form-control" readonly value="{{$projects->title}}">
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Task Name</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="hidden" value="{{ $tasks->id }}" name="task_id">
                                <input class="form-control" readonly value="{{$tasks->title}}">
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Date</label>
                            <div class="col-sm-12 col-md-7">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control datepicker" name="work_date">
                                </div>
                                @error('work_date') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Start Time</label>
                            <div class="col-sm-12 col-md-7">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control timepicker" name="start_time">
                                </div>
                                @error('title') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">End Time</label>
                            <div class="col-sm-12 col-md-7">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control timepicker" name="end_time">
                                </div>
                                @error('title') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <input type="hidden" name="team_id" value="{{ Auth::user()->currentTeam->id }}">

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <button type="submit" class="btn btn-primary">Record Worktime</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>