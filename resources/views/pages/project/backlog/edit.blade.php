<x-app-layout>
    <x-slot name="title">{{ __('Edit Backlog') }}</x-slot>
    <x-slot name="header_content">
        <div class="section-header-back">
            <a href="{{ route('project.show', $projects->id) }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ __('Edit Backlog') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('project.index') }}">Project</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('project.show', $projects->id) }}">#{{ $projects->id }}</a></div>
            <div class="breadcrumb-item">Edit Backlog</div>
        </div>
    </x-slot>

    <h2 class="section-title">Edit Backlog </h2>
    <p class="section-lead mb-3">
        On this page you can edit existing backlog data.
    </p>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Backlog</h4>
                </div>
                <div class="card-body">

                    <form action="/project/{{$projects->id}}/backlog/{{$backlog->id}}/update-backlog" method="post">
                        @csrf
                        @method('PUT')

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Project</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="hidden" value="{{$projects->id}}" name="project_id">
                                <input type="hidden" value="{{$backlog->id}}" name="backlog_id">
                                <input class="form-control" readonly value="{{$projects->title}}">
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Backlog Name</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" name="name" value="{{ $backlog->name }}">
                                @error('name') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Sprint</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control select2" name="sprint_id" required>
                                    <option selected disabled> Select Sprint Iteration</option>
                                    @foreach ($sprints as $sprint)
                                    @if($sprint->status == "1")
                                        <option disabled value="{{ $sprint->id }}" @if($backlog->sprint_id == "$sprint->id") selected="selected" @endif style="color:red">Sprint - {{ $sprint->name }} [CLOSED]</option>
                                    @else
                                        <option value="{{ $sprint->id }}" @if($backlog->sprint_id == "$sprint->id") selected="selected" @endif>Sprint - {{ $sprint->name }}</option>
                                    @endif
                                    @endforeach
                                </select>
                                @error('sprint_id') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Story Point</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="number" class="form-control" name="story_point" value="{{ $backlog->story_point }}" min="1">
                                @error('story_point') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-1">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Description</label>
                            <div class="col-sm-12 col-md-7">
                                <textarea class="summernote-simple" name="description">{{ $backlog->description }}</textarea>
                                @error('description') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <button type="submit" class="btn btn-primary">Update Data</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>