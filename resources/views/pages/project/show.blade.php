<x-app-layout>
    <x-slot name="title">{{ $project->title }}</x-slot>
    <x-slot name="header_content">
        <div class="section-header-back">
            <a href="{{ route('project.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ __($project->title) }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('project.index') }}">Project</a></div>
            <div class="breadcrumb-item">#{{ $project->id }}</div>
        </div>
    </x-slot>

    <div class="row"> 
        <div class="col-12">
            <ul class="nav nav-tabs tab-flex" id="myTab" role="tablist">
                @if(Auth::user()->hasTeamPermission($team, 'view:sprint-backlog'))
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Overview</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="detail-tab" data-toggle="tab" href="#detail" role="tab" aria-controls="detail" aria-selected="false">Detail</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="sprint-tab" data-toggle="tab" href="#sprint" role="tab" aria-controls="sprint" aria-selected="false">Sprint</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="backlog-tab" data-toggle="tab" href="#backlog" role="tab" aria-controls="backlog" aria-selected="false">Backlog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="expenses-tab" data-toggle="tab" href="#expenses" role="tab" aria-controls="expenses" aria-selected="false">Expenses</a>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Overview</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="detail-tab" data-toggle="tab" href="#detail" role="tab" aria-controls="detail" aria-selected="false">Detail</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="expenses-tab" data-toggle="tab" href="#expenses" role="tab" aria-controls="expenses" aria-selected="false">Expenses</a>
                </li>
                @endif
            </ul>
            <div class="tab-content" id="myTabContent">

                <div class="tab-pane fade show active mt-2" id="home" role="tabpanel" aria-labelledby="home-tab">
                    @include('pages.project.show.overview') 
                </div>

                <div class="tab-pane fade" id="detail" role="tabpanel" aria-labelledby="detail-tab">
                    @include('pages.project.show.detail') 
                </div>

                <div class="tab-pane fade" id="sprint" role="tabpanel" aria-labelledby="task-tab">
                    @include('pages.project.show.sprint') 
                </div>

                <div class="tab-pane fade" id="backlog" role="tabpanel" aria-labelledby="backlog-tab">
                    @include('pages.project.show.backlog') 
                </div>

                <div class="tab-pane fade" id="expenses" role="tabpanel" aria-labelledby="expenses-tab">
                    @include('pages.project.show.expenses') 
                </div>

            </div>
        </div>
    </div>

</x-app-layout>

<!-- Modal -->
<div class="modal fade" id="proposalModal" tabindex="-1" role="dialog" aria-labelledby="proposalModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="proposalModalLabel">{{ $project->proposal }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <iframe src="{{ url('/uploads/proposal/'.$project->proposal) }}" class="col-12" height="400px">Your browser isn't compatible</iframe>
        </div>
        <div class="modal-footer bg-whitesmoke">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
            <a href="{{ route('project.proposal', $project->id) }}" class="btn btn-icon icon-left btn-primary" type="button"><i class="fas fa-download"></i>Download File</a>
        </div>
        </div>
    </div>
</div>