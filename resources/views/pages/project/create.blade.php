<x-app-layout>
    <x-slot name="title">{{ __('Create Project') }}</x-slot>
    <x-slot name="header_content">
        <div class="section-header-back">
            <a href="{{ route('project.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ __('Add Project') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('project.index') }}">Project</a></div>
            <div class="breadcrumb-item">Create</div>
        </div>
    </x-slot>

    <h2 class="section-title">Create New </h2>
    <p class="section-lead mb-3">
        On this page you can create a new project and fill in all fields.
    </p>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Add New Project</h4>
                </div>
                <div class="card-body">

                    <form action="{{ route('project.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Title</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                                @error('title') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        
                        @if(empty($clients))
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Client</label>
                            <div class="col-sm-12 col-md-7">
                                <span class="badge badge-danger mt-1">Warning: There's no client yet for this team!</span>
                                <input type="hidden" class="form-control" name="client_id">
                                @error('client_id') <br><span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        @else
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Client</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" value="{{ $clients->name }}" readonly>
                                <input type="hidden" class="form-control" value="{{ $clients->id }}" name="client_id">
                                @error('client_id') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        @endif

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Team</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" value="{{ $teams->name }}" readonly>
                                <input type="hidden" class="form-control" value="{{ $teams->id }}" name="team_id">
                                @error('team_id') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Proposal</label>
                            <div class="col-sm-12 col-md-7">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFileInput" name="proposal"
                                        aria-describedby="customFileInput" value="{{ old('proposal') }}">
                                    <label class="custom-file-label" for="customFileInput">Choose file</label>
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
                                    <input type="text" class="form-control currency" name="budget">
                                </div>
                                @error('budget') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-1">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Details</label>
                            <div class="col-sm-12 col-md-7">
                                <textarea class="summernote" name="description">{{ old('description') }}</textarea>
                                @error('description') <div class="mb-3"><span class="text-red-500">{{ $message }}</span>
                                </div>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Start - End
                                Date</label>
                            <div class="col-sm-12 col-md-7">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control daterange" name="project_date"
                                        value="{{ old('project_date') }}">
                                </div>
                                @error('project_date') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Category</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control select2" name="category">
                                    <option selected disabled> Select Category </option>
                                    <option value="0">Web Development</option>
                                    <option value="1">Mobile App Development</option>
                                    <option value="2">Graphic Design</option>
                                    <option value="3">Content Marketing</option>
                                    <option value="4">Other</option>
                                </select>
                                @error('category') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Platform</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control select2" name="platform">
                                    <option value="0">Default</option>
                                    <option value="1">Web</option>
                                    <option value="2">Mobile</option>
                                    <option value="3">Other</option>
                                </select>
                                @error('platform') <span class="text-red-500">{{ $message }}</span>@enderror
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