<x-app-layout>
    <x-slot name="title">{{ __('Edit Project') }}</x-slot>
    <x-slot name="header_content">
        <div class="section-header-back">
            <a href="{{ url()->previous() }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ __('Edit Project') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('project.index') }}">Project</a></div>
            <div class="breadcrumb-item">Edit</div>
        </div>
    </x-slot>

    <h2 class="section-title">Edit Project </h2>
    <p class="section-lead mb-3">
        On this page you can edit existing project information.
    </p>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Project</h4>
                </div>
                <div class="card-body">

                    <form action="{{ route('project.update', $project->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Title</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" name="title" value="{{ $project->title }}">
                                @error('title') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Client</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" value="{{ $clients->name }}" readonly>
                                <input type="hidden" class="form-control" value="{{ $clients->id }}" name="client_id">
                                @error('client_id') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Team</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" value="{{ $teams->name }}" readonly>
                                <input type="hidden" class="form-control" value="{{ $teams->id }}" name="team_id">
                                @error('team_id') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        @if($project->status == "0" || $project->status == "1")
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Progress</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="hidden" name="progress" value="0">
                                <input type="text" class="form-control text-red-500" style="background-color:#fdfdff" readonly value="You cannot edit progress of project that still did not get approval/rejected."></input>
                            </div>
                        </div>
                        @else
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Progress : <output name="progress" id="progressOutputId">{{ $project->progress }}</output>%</label>
                            <div class="col-sm-12 col-md-7">
                            <input type="range" class="form-control" name="progress" id="progressInputId" value="{{ $project->progress }}" min="0" max="100" oninput="progressOutputId.value = progressInputId.value">
                            
                                @error('progress') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        @endif

                        @if($project->status == "0" || $project->status == "1")
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="hidden" name="status" value="0">
                                <input type="text" class="form-control text-red-500" style="background-color:#fdfdff" readonly value="You cannot edit status of project that still did not get approval/rejected."></input>
                            </div>
                        </div>
                        @else
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control select2" name="status">
                                    <option disabled> Select Status </option>
                                    <option value="2" @if($project->status=="2") selected="selected" @endif>In Progress</option>
                                    <option value="3" @if($project->status=="3") selected="selected" @endif>Completed</option>
                                    <option value="4" @if($project->status=="4") selected="selected" @endif>On Hold</option>
                                    <option value="5" @if($project->status=="5") selected="selected" @endif>Cancelled</option>
                                </select>
                            </div>
                            @error('status') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        @endif

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Proposal</label>
                            <div class="col-sm-12 col-md-7">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFileInput" name="proposal" aria-describedby="customFileInput">
                                    <label class="custom-file-label" for="customFileInput">{{ $project->proposal }}</label>
                                    <small class="form-text text-muted mt-3">
                                        File format are PDF or Word, and file size must be below 2 Mb.
                                    </small>
                                    @error('proposal') <span class="text-red-500">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Budget</label>
                            <div class="col-sm-12 col-md-7">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">$</div>
                                    </div>
                                    <input type="text" class="form-control currency" name="budget" value="'{{ $project->budget }}'">
                                    @error('budget') <span class="text-red-500">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-1">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Details</label>
                            <div class="col-sm-12 col-md-7">
                                <textarea class="summernote" name="description">{{ $project->description }}</textarea>
                                @error('description') <span class="text-red-500">{{ $message }}</span>@enderror
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
                                    <input type="text" class="form-control daterange" name="project_date" value="{{ $dates }}">
                                </div>
                                @error('project_date') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Category</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control select2" name="category">
                                    <option disabled> Select Category </option>
                                    <option value="0" @if($project->category=="0") selected="selected" @endif>Web Development</option>
                                    <option value="1" @if($project->category=="1") selected="selected" @endif>Mobile App Development</option>
                                    <option value="2" @if($project->category=="2") selected="selected" @endif>Graphic Design</option>
                                    <option value="3" @if($project->category=="3") selected="selected" @endif>Content Marketing</option>
                                    <option value="4" @if($project->category=="4") selected="selected" @endif>Other</option>
                                </select>
                            </div>
                            @error('category') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Platform</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control select2" name="platform">
                                    <option value="0" @if($project->platform=="0") selected="selected" @endif>Default</option>
                                    <option value="1" @if($project->platform=="1") selected="selected" @endif>Web</option>
                                    <option value="2" @if($project->platform=="2") selected="selected" @endif>Mobile</option>
                                    <option value="3" @if($project->platform=="3") selected="selected" @endif>Other</option>
                                </select>
                            </div>
                            @error('platform') <span class="text-red-500">{{ $message }}</span>@enderror
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

    @push('custom-scripts')
    <script>
        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            var name = document.getElementById("customFileInput").files[0].name;
            var nextSibling = e.target.nextElementSibling
            nextSibling.innerText = name
        });
    </script>

    <script>
        var cleaveC = new Cleave('.currency', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand'
        });
    </script>
    @endpush

</x-app-layout>
