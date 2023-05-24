<x-app-layout>
    <x-slot name="title">{{ $project->title }} - {{ __('Sprint Reports') }}</x-slot>
    <x-slot name="header_content">

        <div class="section-header-back">
            <a href="{{ route('report.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ $project->title }} - {{ __('Sprint Reports') }}</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('project.show', $project->id) }}">#{{$project->id}}</a></div>
            <div class="breadcrumb-item">Sprint Reports</div>
        </div>
    </x-slot>

    <h2 class="section-title">Sprint Reports</h2>
    <p class="section-lead mb-3">
        You can view sprint report from {{ $project->title }} here.
    </p>

    <div class="card">
        <div class="card-body">
            <button type="button" class="btn btn-primary mr-2" onclick="printContent('content')"><i class="fas fa-print"></i> Print</button>
            <button type="button" class="btn btn-primary btn-icon icon-left mr-2" data-toggle="tooltip" title="The total number of sprint in this project.">
                <i class="fas fa-folder-open"></i> Total Sprint <span class="badge badge-transparent">{{ count($sprints) }}</span>
            </button>
            <div class="btn-group">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-chart-line"></i>&nbsp; Sprint Burndown
                </button>
                <div class="dropdown-menu">
                    <div class="dropdown-title">{{ $project->title }} Sprints</div>
                    @foreach($sprints as $sprint)
                        <a class="dropdown-item" href="{{ route("project.report.sprint.burndown", ["id" => $project->id, "sprint" => $sprint->id])}}">Sprint - {{$sprint->name}}</a>
                    @endforeach
                </div>
              </div>
        </div>
    </div>

    <div id="content">
        @forelse($sprints as $sprint)
        <div class="card">
            <div class="card-header">
                <h4>Sprint - {{$sprint->name}}</h4>
                @if($sprint->status == "0")
                <span class="badge badge-primary ml-1">Open</span>
                @elseif($sprint->status == "1")
                <span class="badge badge-success ml-1">Closed</span>
                @endif
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-3">
                        @php
                            $start_date = $sprint->start_date;
                            $end_date = $sprint->end_date;
                            $sprint_length = round(abs(strtotime($start_date) - strtotime($end_date))/86400)+1;
                        @endphp
                        <p><b>Sprint Length </b> : {{ $sprint_length }} days</p>
                        <p><b>Man Days</b> : {{ $total_member * $sprint_length }}</p>
                    </div>
                    <div class="col-12 col-md-4">
                        <p><b>Focus Factor</b> : {{ $sprint->focus_factor }}%</p>
                        <p><b>Total Story Point for This Sprint</b> : {{ $sprint->total_sp }}</p>
                    </div>
                </div>

                <div class="mb-4"></div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 5%;">#</th>
                            <th scope="col" style="width: 25%;">Sprint Backlog</th>
                            <th scope="col" style="width: 58%;">Tasks</th>
                            <th scope="col" style="width: 12%;" align="center">Story Point</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($backlogs->where('sprint_id', $sprint->id) as $backlog)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>

                                @if(empty($backlog))
                                    Data empty
                                @else
                                    {{ $backlog->name }}
                                @endif
                            </td>

                            <td>
                                <ul class="pl-2 mt-3">
                                    @forelse($tasks->where('sprint_id', $sprint->id)->where('backlog_id', $backlog->id) as $task)
                                        <li>{{ $task->title }}</li>
                                    @empty
                                        <p style="color:red">No task found for this backlog.</p>
                                    @endforelse
                                </ul>
                            </td>

                            <td align="center">
                                @if(empty($backlog))
                                    Data empty
                                @else
                                    {{ $backlog->story_point }}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            @php
                                $current_total = 0;
                                foreach($backlogs->where('sprint_id', $sprint->id) as $data){
                                    $current_total = $current_total + $data->story_point;
                                }
                            @endphp
                            <td colspan="3" align="right"><b>Total</b></td>
                            <td align="center">{{ $current_total }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        @empty
        <div class="card">
            <div class="card-header">
                <h4>Empty Data</h4>
            </div>
            <div class="card-body">
                <div class="empty-state" data-height="400">
                    <div class="empty-state-icon">
                        <i class="fas fa-question"></i>
                    </div>
                    <h2>We couldn't find any data</h2>
                    <p class="lead">
                        Sorry we can't find any data regarding sprint reports for this project.
                    </p>
                </div>
            </div>
        </div>
        @endforelse
    </div>

</x-app-layout>