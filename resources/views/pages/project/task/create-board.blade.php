<x-app-layout>
    <x-slot name="title">{{ __('Create Board') }} - {{ $projects->title }}</x-slot>
    <x-slot name="header_content">
        <div class="section-header-back">
            <a href="{{ url()->previous() }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ __('Add Board') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('project.index') }}">Project</a></div>
            <div class="breadcrumb-item active"><a href="../{{ $projects->id }}">#{{ $projects->id }}</a></div>
            <div class="breadcrumb-item">Create Board</div>
        </div>
    </x-slot>

    <h2 class="section-title">Create New </h2>
    <p class="section-lead mb-3">
        On this page you can create a new board data.
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
                            <a class="nav-link active" href="#"><i class="fas fa-plus"></i> New Board</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/project/{{$projects->id}}/create-task"><i class="fas fa-plus"></i> New Task</a>
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

                    <form action="/project/store-board" method="post">
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
