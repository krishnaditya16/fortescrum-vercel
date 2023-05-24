<x-app-layout>
    <x-slot name="title">{{ $data->title }}</x-slot>
    <x-slot name="header_content">
        <div class="section-header-back">
            <a href="{{ url()->previous() }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ __('Tasks Table') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('project.index') }}">Project</a></div>
            <div class="breadcrumb-item active"><a href="../{{ $data->id }}">#{{ $data->id }}</a></div>
            <div class="breadcrumb-item">Tasks Table</div>
        </div>
    </x-slot>

    <h2 class="section-title">Tasks Table </h2>
    <p class="section-lead mb-3">
        You can manage & view tasks data using the table below.
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
                            <a class="nav-link" href="/project/{{$data->id}}/tasks"><i class="fas fa-chalkboard"></i> Kanban View</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#"><i class="fas fa-table"></i> Table View</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/project/{{$data->id}}/gantt-chart"><i class="fas fa-project-diagram"></i> Gantt Chart</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/project/{{$data->id}}/create-board"><i class="fas fa-plus"></i> New Board</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/project/{{$data->id}}/create-task"><i class="fas fa-plus"></i> New Task</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('project.task.finished', $data->id) }}"><i class="fas fa-clipboard-check"></i> Finished Task</a>
                        </li>
                        @else
                        <li class="nav-item">
                            <a class="nav-link" href="/project/{{$data->id}}/tasks"><i class="fas fa-chalkboard"></i> Kanban View</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#"><i class="fas fa-table"></i> Table View</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('project.task.finished', $data->id) }}"><i class="fas fa-clipboard-check"></i> Finished Task</a>
                        </li>
                        @endif
                    </ul>
                </div>
                <div class="card-body">
                    @livewire('task.task-project', ['project' => $data])
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
