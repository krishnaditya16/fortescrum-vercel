<x-app-layout>
    <x-slot name="title">{{ $project->title }} - {{ __('Meeting') }}</x-slot>
    <x-slot name="header_content">

        <div class="section-header-back">
            <a href="{{ route('meeting.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ $project->title }} - {{ __('Meeting') }}</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('project.show', $project->id) }}">Project - #{{$project->id}}</a></div>
            <div class="breadcrumb-item">Meeting</div>
        </div>
    </x-slot>

    <h2 class="section-title">Meeting Data</h2>
    <p class="section-lead mb-3">
        You can view avalaible meeting from {{ $project->title }} here.
    </p>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-header-action">
                        <a href="{{ route('project.meeting.create', $project->id) }}" class="btn btn-icon icon-left btn-outline-dark"><i class="fas fa-plus"></i> Add Data</a>
                    </div>
                </div>
                <div class="card-body">
                    <livewire:meeting.meeting-table project="{{ $project->id }}" />
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Calendar</h4>
                </div>
                <div class="card-body">
                    <div id="calendar" data-meetings="{{ $meetings }}"></div>
                </div>
            </div>
        </div>
    </div>
    
    @push('custom-scripts')
        <script src="{{ asset('stisla/js/meeting-calendar.js') }}"></script>
    @endpush

</x-app-layout>

<div class="modal fade" id="meetingModal">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="meetingModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <hr class="mb-6">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-8">
                        <h4 class="mb-4"><i class="fas fa-book"></i>&nbsp; Description</h4>
                        <p class="mb-4" id="meetingModalDescription"></p>
                        <hr class="mb-4 mt-4">
                    </div>
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="mb-4">
                            <h4><i class="fas fa-calendar"></i>&nbsp; Date</h4>
                            <p class="mb-4" id="meetingModalDate"></p>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-6">
                                <h4><i class="fas fa-clock"></i>&nbsp; Start Time</h4>
                                <p class="mb-4" id="meetingModalStartTime"></p>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <h4><i class="fas fa-business-time"></i> End Time</h4>
                                <p class="mb-4" id="meetingModalEndTime"></p>
                            </div>
                        </div>
                        <div class="mb-4">
                            <h4><i class="fas fa-thumbtack"></i>&nbsp; Meeting Link/Location</h4>
                            <p id="meetingModalLocation"></p>
                            <p><a id="meetingModalLink" href="#" target="_blank"></a></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
            </div>
        </div>
    </div>
</div>
