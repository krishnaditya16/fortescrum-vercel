<x-app-layout>
    <x-slot name="title">{{ __('Edit Backlog') }}</x-slot>
    <x-slot name="header_content">
        <div class="section-header-back">
            <a href="{{ url()->previous() }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ __('Edit Backlog') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('backlog.index') }}">Backlog</a></div>
            <div class="breadcrumb-item">Edit</div>
        </div>
    </x-slot>

    <h2 class="section-title">Edit Backlog</h2>
    <p class="section-lead mb-3">
        On this page you can edit existing backlog data.
    </p>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Add New Backlog</h4>
                </div>
                <div class="card-body">

                    <form action="{{ route('backlog.update', $backlog->id) }}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Project</label>
                            <div class="col-sm-12 col-md-7">
                                @php
                                    foreach($projects as $project){
                                        if($project->id == $backlog->project_id){
                                            $project_name = $project->title;
                                            break;
                                        }
                                    }
                                @endphp
                                <input type="hidden" name="project_id" value="{{ $backlog->project_id }}">
                                <input type="text" class="form-control" value="{{ $project_name }}" readonly>
                                @error('project_id') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Sprint Iteration</label>
                            <div class="col-sm-12 col-md-7">
                                @php
                                    foreach($sprints as $sprint){
                                        if($sprint->id == $backlog->sprint_id){
                                            $sprint_name = $sprint->name;
                                            break;
                                        }
                                    }
                                @endphp
                                <input type="hidden" name="sprint_id" value="{{ $backlog->sprint_id }}">
                                <input type="number" class="form-control" value="{{ $sprint_name }}" readonly>
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

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Backlog Name</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" name="name" value="{{ $backlog->name }}">
                                @error('name') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-1">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Description</label>
                            <div class="col-sm-12 col-md-7">
                                <textarea class="summernote-simple" name="description">{{ $backlog->description }}</textarea>
                                @error('description') <div class="mb-3"><span class="text-red-500">{{ $message }}</span></div>@enderror
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
