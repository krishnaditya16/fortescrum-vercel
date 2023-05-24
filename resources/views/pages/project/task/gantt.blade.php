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
            <div class="breadcrumb-item">Tasks Gantt Chart</div>
        </div>
    </x-slot>

    <h2 class="section-title">Tasks Gantt Chart</h2>
    <p class="section-lead mb-3">
        You can view task gantt chart below.
    </p>

    @php
        $team = Auth::user()->currentTeam;
        $user = Auth::user();
    @endphp

    @if($user->hasTeamRole($team, 'client-user'))
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="btn-group-gantt">
                        <div class="btn-group d-flex mb-3" role="group"></div>
                    </div>
                    <div id="gantt"></div>
                </div>
            </div>
        </div>
    </div>
    @else
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
                            <a class="nav-link" href="/project/{{$data->id}}/table-view"><i class="fas fa-table"></i> Table View</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#"><i class="fas fa-project-diagram"></i> Gantt Chart</a>
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
                    <div class="btn-group-gantt">
                        <div class="btn-group d-flex mb-3" role="group"></div>
                    </div>
                    <div id="gantt"></div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const project = @json($data);
            const sprints = @json($sprint);
            const tasks = @json($task);

            const taskItems = [
                {
                    id: project.id,
                    name: project.title,
                    start: project.start_date,
                    end: project.end_date,
                    progress: project.progress,
                    dependencies: sprints.map(sprint => sprint.id) // Dependencies on sprint IDs
                },
                ...sprints.map(sprint => ({
                    id: sprint.id,
                    name: `Sprint: ${sprint.name}`,
                    start: sprint.start_date,
                    end: sprint.end_date,
                    progress: sprint.status === 1 ? 100 : 0, // Set progress to 100 for status 1 (closed) and 0 for status 0 (open)
                    custom_class: sprint.status === 1 ? 'sprint-closed' : 'sprint-open',
                    dependencies: tasks.filter(task => task.sprint_id === sprint.id).map(task => task.id) // Dependencies on task IDs within the sprint
                })),
                ...tasks.map(task => ({
                    id: task.id,
                    name: task.title,
                    start: task.start_date,
                    end: task.end_date,
                    progress: task.progress,
                    dependencies: []
                }))
            ];

            const gantt = new Gantt("#gantt", taskItems, {
                header_height: 50,
                column_width: 30,
                step: 24,
                view_modes: ['Quarter Day', 'Half Day', 'Day', 'Week', 'Month'],
                bar_height: 20,
                bar_corner_radius: 3,
                arrow_curve: 5,
                padding: 18,
                view_mode: 'Week',
                date_format: 'YYYY-MM-DD',
                custom_popup_html: function (task) {
                    const startDate = moment(task.start).format('MMM DD');
                    const endDate = moment(task.end).format('MMM DD');
                    const duration = moment(task.end).diff(moment(task.start), 'days') + 1;

                    return `<div class="details-container">
                                <div class="title">${task.name}: ${startDate} - ${endDate}</div>
                                <div class="subtitle">
                                    Duration: ${duration} days<br>
                                    Progress: ${task.progress}%
                                </div>
                            </div>`;
                }
            });

            gantt.change_view_mode('Week'); // Initial view mode

            // Function to handle view mode change
            function changeViewMode(viewMode) {
                gantt.change_view_mode(viewMode);
            }

            // Create buttons using Bootstrap Button Group class
            const viewModes = ['Quarter Day', 'Half Day', 'Day', 'Week', 'Month'];
            const buttonGroup = document.querySelector('.card-body .btn-group');

            viewModes.forEach(viewMode => {
                const button = document.createElement('button');
                button.classList.add('btn', 'btn-secondary');
                button.textContent = viewMode;
                button.addEventListener('click', () => changeViewMode(viewMode));
                buttonGroup.appendChild(button);
            });

            // Optional: Handle window resize to adjust the chart size
            window.addEventListener('resize', function () {
                gantt.refresh();
            });
        });
    </script>

</x-app-layout>
