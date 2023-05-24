<x-app-layout>
    <x-slot name="title">{{ __('Create Meeting') }}</x-slot>
    <x-slot name="header_content">
        <div class="section-header-back">
            <a href="{{ url()->previous() }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ __('Add Meeting') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('project.index') }}">Project</a></div>
            <div class="breadcrumb-item active"><a href="../{{ $project->id }}">#{{ $project->id }}</a></div>
            <div class="breadcrumb-item">Create Meeting</div>
        </div>
    </x-slot>

    <h2 class="section-title">Create New </h2>
    <p class="section-lead mb-3">
        On this page you can create a new meeting data.
    </p>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Add New Meeting</h4>
                </div>
                <div class="card-body">

                    <form action="/project/store-meeting" method="post">
                        @csrf

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Project</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="hidden" name="project_id" value="{{ $project->id }}">
                                <input type="hidden" name="team_id" value="{{ Auth::user()->currentTeam->id }}">
                                <input type="text" class="form-control" name="name" value="{{ $project->title }}" readonly>
                                @error('project_id') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Title</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                                @error('title') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Date</label>
                            <div class="col-sm-12 col-md-7">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control datepicker" name="meeting_date">
                                </div>
                                @error('meeting_date') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">From</label>
                            <div class="col-sm-12 col-md-7">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control timepicker" name="start_time">
                                </div>
                                @error('start_time') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">To</label>
                            <div class="col-sm-12 col-md-7">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control timepicker" name="end_time">
                                </div>
                                @error('end_time') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Type</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control select2" name="type" id="meetingType">
                                    <option selected disabled> Select Type </option>
                                    <option value="0">Offline</option>
                                    <option value="1">Online</option>
                                </select>
                                @error('type') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4" style="display: none;" id="meetingLink">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Meeting Link</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" name="meeting_link" value="{{ old('meeting_link') }}" id="link">
                                @error('meeting_link') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4" style="display: none;" id="meetingLocation">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Meeting Location</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" name="meeting_location" value="{{ old('meeting_location') }}" id="location">
                                @error('meeting_location') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-1">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Description</label>
                            <div class="col-sm-12 col-md-7">
                                <textarea class="summernote-simple" name="description">{{ old('description') }}</textarea>
                                @error('description') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <input type="hidden" name="from_mail" value="{{ Auth::user()->email }}">
                        <input type="hidden" name="mail_sender" value="{{ Auth::user()->name }}">
                        
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <button type="submit" class="btn btn-primary">Create Data</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
