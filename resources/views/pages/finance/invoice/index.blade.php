<x-app-layout>
    <x-slot name="title">{{ __('Project Invoice') }}</x-slot>
    <x-slot name="header_content">
        <div class="section-header-back">
            <a href="{{ url()->previous() }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ __('Project Invoice') }}</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('project.index') }}">Project</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('project.show', $project->id) }}">#{{$project->id}}</a></div>
            <div class="breadcrumb-item">Manage Invoice</div>
        </div>
    </x-slot>

    <h2 class="section-title">Project Invoice</h2>
    <p class="section-lead mb-3">
        Select either one of the project data avalaible below to view project Invoice.
    </p>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ $project->title }} - Invoice</h4>
                    @if(Auth::user()->ownsTeam($team) || Auth::user()->hasTeamRole($team, 'project-manager')) 
                    <div class="card-header-action">
                        <a href="{{ route('project.invoice.create', $project->id) }}" class="btn btn-icon icon-left btn-outline-dark"><i class="fas fa-plus"></i> Add Data</a>
                    </div>
                    @endif
                </div>
                <div class="card-body">
                    @livewire('finance.invoice-project-table', ['project' => $project->id])
                </div>
            </div>
        </div>
    </div>

</x-app-layout>