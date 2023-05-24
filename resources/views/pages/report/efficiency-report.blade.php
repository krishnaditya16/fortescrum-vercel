<x-app-layout>
    <x-slot name="title">{{ $project->title }} - {{ __('Efficiency Reports') }}</x-slot>
    <x-slot name="header_content">

        <div class="section-header-back">
            <a href="{{ route('report.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ $project->title }} - {{ __('Efficiency Reports') }}</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a
                    href="{{ route('project.show', $project->id) }}">#{{$project->id}}</a></div>
            <div class="breadcrumb-item">Efficiency Reports</div>
        </div>
    </x-slot>

    <h2 class="section-title">Efficiency Reports</h2>
    <p class="section-lead mb-3">
        You can view Efficiency report from {{ $project->title }} here.
    </p>

    <div class="card">
        <div class="card-body">
            <button type="button" class="btn btn-primary mr-2" onclick="printContent('content')"><i
                    class="fas fa-print"></i> Print</button>
        </div>
    </div>

    <div id="content">
        <div class="row">
            {{-- <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Individual Performance</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr align="center">
                                    <th scope="col" style="width: 10%;">#</th>
                                    <th scope="col" style="width: 30%;">Team Member</th>
                                    <th scope="col" style="width: 20%;">Efficiency</th>
                                    <th scope="col" style="width: 20%;">Task Completion Rate</th>
                                    <th scope="col" style="width: 20%;">Performance Score (0-100)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($performanceData as $performanceItem)
                                <tr>
                                    <td scope="row" align="center">{{$loop->iteration}}</td>
                                    <td>
                                        @if(is_null($performanceItem['teamMember']->profile_photo_path))
                                        @php
                                            $name = trim(collect(explode(' ', $performanceItem['teamMember']->name))->map(function ($segment) {
                                            return mb_substr($segment, 0, 1);
                                            })->join(''));
                                        @endphp
                                        <div class="media">
                                            <figure class="avatar mr-3" data-initial="{{$name}}" data-toggle="tooltip" title="{{ $performanceItem['teamMember']->name }}"></figure>
                                            <div class="media-body">
                                                <div class="mt-0 font-weight-bold">{{ $performanceItem['teamMember']->name }}</div>
                                                <div class="text-small font-600-bold">{{ $performanceItem['teamMember']->email }}</div>
                                            </div>
                                        </div>
                                        @else
                                        <div class="media">
                                            <figure class="avatar mr-3">
                                                <img src="{{ asset('storage/'.$performanceItem['teamMember']->profile_photo_path) }}" alt="{{ $performanceItem['teamMember']->name }}" data-toggle="tooltip" title="{{ $performanceItem['teamMember']->name }}">
                                            </figure>
                                            <div class="media-body">
                                                <div class="mt-0 font-weight-bold">{{ $performanceItem['teamMember']->name }}</div>
                                                <div class="text-small font-600-bold">{{ $performanceItem['teamMember']->email }}</div>
                                            </div>
                                        </div>
                                        @endif
                                    </td>

                                    <td>
                                        <p>{{ $performanceItem['efficiency'] }}</p>
                                    </td>

                                    <td>
                                        <p>{{ $performanceItem['taskCompletionRate'] }}</p>
                                    </td>
                
                                    <td align="center">
                                        <p>{{ $performanceItem['performance'] }}</p>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> --}}
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Task Flow Efficiency</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr align="center">
                                    <th scope="col" style="width: 5%;">#</th>
                                    <th scope="col" style="width: 20%;">Completed Task</th>
                                    <th scope="col" style="width: 20%;">Task Duration</th>
                                    <th scope="col" style="width: 20%;">Work Time</th>
                                    <th scope="col" style="width: 20%;">Wait Time</th>
                                    <th scope="col" style="width: 15%;">Flow Efficiency (0-100%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($flowEfficiencyData as $item)
                                <tr>
                                    @php
                                        $startDate = \Carbon\Carbon::parse($item['task']->start_date);
                                        $endDate = \Carbon\Carbon::parse($item['task']->end_date);
                                        $taskDuration = $startDate->diffInDays($endDate);
                                    @endphp
                                    <td scope="row" align="center">{{$loop->iteration}}</td>
                                    <td>
                                        <p>{{ $item['task']->title }}</p>
                                    </td>
                                    <td>
                                        <p>{{ $item['taskDurationDays'] }} Days</p>
                                    </td>
                                    <td>
                                        @if($item['totalWorkDuration'] == 0)
                                            @if($item['workDurationHours'] < 1)
                                                <p>{{ $item['workDurationHours']*60 }} Minutes</p>
                                            @else
                                                <p>{{ $item['workDurationHours'] }} Hours</p>
                                            @endif
                                        @else
                                            <p>{{ $item['totalWorkDuration'] }} Days</p>
                                        @endif
                                    </td>
                                    <td>
                                        <p>{{ $item['waitDurationDays'] }} Days</p>
                                    </td>
                                    <td align="center">
                                        <p>{{ $item['flowEfficiency'] }}%</p>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Task Flow Efficiency Chart</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="flowEfficiencyChart" data-efficiency="{{ json_encode($flowEfficiencyData) }}"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('custom-scripts')
        <script src="{{ asset('stisla/js/flow-efficiency-chart.js') }}"></script>
    @endpush

</x-app-layout>

