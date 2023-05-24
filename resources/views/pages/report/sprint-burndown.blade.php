<x-app-layout>
    <x-slot name="title">{{ $projects->title }} - {{ __('Sprint Burndown') }}</x-slot>
    <x-slot name="header_content">

        <div class="section-header-back">
            <a href="{{ route('project.report.sprint', $projects->id) }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ $projects->title }} - {{ __('Sprint Burndown') }}</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a
                    href="{{ route('project.show', $projects->id) }}">#{{$projects->id}}</a></div>
            <div class="breadcrumb-item">Sprint-{{ $sprints->name }} Burndown</div>
        </div>
    </x-slot>

    <h2 class="section-title">Sprint-{{ $sprints->name }} Burndown</h2>
    <p class="section-lead mb-3">
        You can view Sprint-{{ $sprints->name }} burndown from {{ $projects->title }} here.
    </p>

    {{-- <div class="card">
        <div class="card-body">
            <button type="button" class="btn btn-primary mr-2" id="printDiagram"><i
                    class="fas fa-print"></i> Print</button>
        </div>
    </div> --}}

    <div id="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Sprint-{{ $sprints->name }} Burndown</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="burndownChart" data-sprint="{{ json_encode($chartData) }}" data-ideal="{{ json_encode($idealBurndownData) }}"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('custom-scripts')
        <script src="{{ asset('stisla/js/sprint-burndown.js') }}"></script>
    @endpush

</x-app-layout>

