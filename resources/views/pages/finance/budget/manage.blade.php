<x-app-layout>
    <x-slot name="title">{{ __('Manage Project Budget') }}</x-slot>
    <x-slot name="header_content">
        <div class="section-header-back">
            <a href="{{ url()->previous() }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ __('Manage Budget') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('project.index') }}">Project</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('project.show', $project->id) }}">#{{$project->id}}</a></div>
            <div class="breadcrumb-item">Manage Budget</div>
        </div>
    </x-slot>

    <h2 class="section-title">Manage Budget </h2>
    <p class="section-lead mb-3">
        On this page you can manage project budget data.
    </p>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Manage Budget</h4>
                </div>
                <div class="card-body">

                    <form action="{{ route('project.budget.update', $project->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Title</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" name="title" value="{{ $project->title }}" readonly>
                                @error('title') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Client</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" value="{{ $client->name }}" readonly>
                                @error('client_id') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Team</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" value="{{ $team->name }}" readonly>
                                @error('team_id') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Currently Used</label>
                            <div class="col-sm-12 col-md-7">
                            @php
                                if($project->budget != 0){
                                    $percentage = ($spending / $project->budget)*100;
                                } else {
                                    $percentage = 0;
                                }
                            @endphp
                            <div class="progress-text mb-2">${{ number_format($spending) }} of ${{ number_format($project->budget) }} Used</div>
                            <div class="progress" data-height="6" style="height: 6px;" data-toggle="tooltip" title="{{ $percentage }}%">
                                <div class="progress-bar
                                @if($percentage > 100)
                                    bg-danger
                                @elseif($percentage > 80 && $percentage <= 100)
                                    bg-warning
                                @else 
                                    bg-primary
                                @endif"
                                    data-width="{{ $percentage }}%" aria-valuenow="{{ $percentage }}" aria-valuemin="0"></div>
                                </div>
                            @if($percentage > 100)
                                <div class="progress-text"><span class="text-red-600">Budget Overused</span> </div>
                            @elseif($percentage > 80 && $percentage <= 100)
                                <div class="progress-text"><span style="color: #ffa426">More than 80% of budget used</span> </div>
                            @endif
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
        var cleaveC = new Cleave('.currency', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand'
        });
    </script>
    @endpush

</x-app-layout>
