<x-app-layout>
    <x-slot name="title">{{ $project->title }} - {{ __('Timesheet Reports') }}</x-slot>
    <x-slot name="header_content">

        <div class="section-header-back">
            <a href="{{ route('report.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ $project->title }} - {{ __('Timesheet Reports') }}</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('project.show', $project->id) }}">#{{$project->id}}</a></div>
            <div class="breadcrumb-item">Timesheet Reports</div>
        </div>
    </x-slot>

    <h2 class="section-title">Timesheet Reports</h2>
    <p class="section-lead mb-3">
        You can view timesheet report from {{ $project->title }} here.
    </p>

    <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>{{ $project->title }} - Timesheet Report</h4>
            </div>

            <div class="card-body">
                <livewire:timesheet.timesheet-report-table project="{{ $project->id }}" />
            </div>

        </div>
    </div>
</div>

</x-app-layout>