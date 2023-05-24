<x-app-layout>
    <x-slot name="title">{{ __('Create Backlog') }}</x-slot>
    <x-slot name="header_content">
        <div class="section-header-back">
            <a href="{{ route('project.show', $projects->id) }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ __('Add Backlog') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('project.index') }}">Project</a></div>
            <div class="breadcrumb-item active"><a href="../{{ $projects->id }}">#{{ $projects->id }}</a></div>
            <div class="breadcrumb-item">Create Backlog</div>
        </div>
    </x-slot>

    <h2 class="section-title">Create New </h2>
    <p class="section-lead mb-3">
        On this page you can create a new backlog data.
    </p>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Add New Backlog</h4>
                </div>
                <div class="card-body">

                    <form action="/project/store-backlog" method="post">
                        @csrf

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Project</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="hidden" value="{{$projects->id}}" name="project_id">
                                <input class="form-control" readonly value="{{$projects->title}}">
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Backlog Name</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
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
                                        <option disabled value="{{ $sprint->id }}" style="color:red">Sprint - {{ $sprint->name }} [CLOSED]</option>
                                        @else
                                        <option value="{{ $sprint->id }}">Sprint - {{ $sprint->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('sprint_id') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Story Point</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="number" class="form-control" name="story_point" value="{{ old('story_point') }}" min="1">
                                @error('story_point') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-1">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Description</label>
                            <div class="col-sm-12 col-md-7">
                                <textarea class="summernote-simple" name="description">{{ old('description') }}</textarea>
                                @error('description') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

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