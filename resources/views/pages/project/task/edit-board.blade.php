<x-app-layout>
    <x-slot name="title">{{ __('Edit Board') }} - {{ $projects->title }}</x-slot>
    <x-slot name="header_content">
        <div class="section-header-back">
            <a href="{{ url()->previous() }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ __('Edit Board') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('project.index') }}">Project</a></div>
            <div class="breadcrumb-item active"><a href="../{{ $projects->id }}">#{{ $projects->id }}</a></div>
            <div class="breadcrumb-item">Edit Board</div>
        </div>
    </x-slot>

    <h2 class="section-title">Edit Board</h2>
    <p class="section-lead mb-3">
        On this page you can existing board data.
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
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('project.task.finished', $projects->id) }}"><i class="fas fa-clipboard-check"></i> Finished Task</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <form action="/project/{{$projects->id}}/tasks/update-board/{{$board->id}}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Project</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="hidden" value="{{$projects->id}}" name="project_id">
                                <input type="hidden" value="{{$board->id}}" name="board_id">
                                <input class="form-control" readonly value="{{$projects->title}}">
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Title</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" name="title" value="{{$board->title}}">
                                @error('title') <span class="text-red-500">{{ $message }}</span>@enderror
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
