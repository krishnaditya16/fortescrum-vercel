<x-app-layout>
    <x-slot name="title">{{ __('Edit Sprint') }}</x-slot>
    <x-slot name="header_content">
        <div class="section-header-back">
            <a href="{{ route('project.show', $projects->id) }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ __('Edit Sprint') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('project.index') }}">Project</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('project.show', $projects->id) }}">#{{ $projects->id }}</a></div>
            <div class="breadcrumb-item">Edit Sprint</div>
        </div>
    </x-slot>

    <h2 class="section-title">Edit Sprint </h2>
    <p class="section-lead mb-3">
        On this page you can edit existing sprint data.
    </p>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Sprint</h4>
                </div>
                <div class="card-body">

                    <form action="/project/{{$projects->id}}/sprint/{{$sprint->id}}/update-sprint" method="post">
                        @csrf
                        @method('PUT')

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Project</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="hidden" value="{{$projects->id}}" name="project_id">
                                <input type="hidden" value="{{$sprint->id}}" name="sprint_id">
                                <input class="form-control" readonly value="{{$projects->title}}">
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Sprint Iteration</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="number" class="form-control" name="name" value="{{ $sprint->name }}" min="1">
                                @error('name') <span class="text-red-500">{{ $message }}</span>@enderror
                                <small class="form-text text-muted">
                                    Sprint iteration is the number of sprint done in a project. Input above must only be field with number.
                                </small>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Focus Factor</label>
                            <div class="col-sm-12 col-md-7">
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" name="focus_factor" value="{{ $sprint->focus_factor }}" min="1" max="100">
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                                @error('focus_factor') <span class="text-red-500">{{ $message }}</span>@enderror
                                <small class="form-text text-muted">
                                    Focus factor is team focus level estimation.
                                </small>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Start - End Date</label>
                            <div class="col-sm-12 col-md-7">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control daterange" name="sprint_date" value="{{ $dates }}">
                                </div>
                                @error('sprint_date') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-1">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Description</label>
                            <div class="col-sm-12 col-md-7">
                                <textarea class="summernote-simple" name="description">{{ $sprint->description }}</textarea>
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