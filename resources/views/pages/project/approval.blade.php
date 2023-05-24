<x-app-layout>
    <x-slot name="title">{{ __('Project Approval') }}</x-slot>
    <x-slot name="header_content">
        <div class="section-header-back">
            <a href="{{ route('project.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ __('Project Approval') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('project.show', $project->id) }}">Project</a></div>
            <div class="breadcrumb-item">Approval</div>
        </div>
    </x-slot>

    <h2 class="section-title">Project Approval </h2>
    <p class="section-lead mb-3">
        On this page you can edit project status and view project proposal.
    </p>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Project : {{ $project->title }} </h4>
                </div>
                <div class="card-body">

                    @error('status')
                    <div align="middle">
                        <div class="alert alert-danger alert-dismissible show fade col-8">
                            <div class="alert-body">
                                <button class="close" data-dismiss="alert">
                                    <span>×</span>
                                </button>
                                {{ $message }}</span>
                            </div>
                        </div>
                    </div>
                    @enderror

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Proposal File</label>
                        <div class="col-sm-12 col-md-7">
                            <a href="{{ route('project.proposal', $project->id) }}" class="btn btn-icon icon-left btn-primary mt-2" type="button"><i class="fas fa-download"></i>Download File</a>
                            <button class="btn btn-primary mt-2" data-toggle="modal" data-target="#proposalModal"><i class="fas fa-eye"></i> View File</button>
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status Now</label>
                        <div class="col-sm-12 col-md-7">
                            @if($project->status == "0")
                            <div class="badge badge-secondary">Waiting Approval</div>
                            @elseif($project->status == "1")
                            <div class="badge badge-danger">Rejected</div>
                            @elseif($project->status == "2")
                            <div class="badge badge-info">In Progress</div>
                            @elseif($project->status == "3")
                            <div class="badge badge-success">Completed</div>
                            @elseif($project->status == "4")
                            <div class="badge badge-warning">On Hold</div>
                            @elseif($project->status == "5")
                            <div class="badge badge-danger">Cancelled</div>
                            @endif
                        </div>
                    </div>

                    <form action="{{ route('project.approval', $project->id) }}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Project Status</label>
                            <div class="col-sm-12 col-md-7">
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="status" value="2" class="selectgroup-input">
                                        <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-check"></i> &nbsp; Approve</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="status" value="1" class="selectgroup-input">
                                        <span class="selectgroup-button"><i class="fas fa-times"></i> &nbsp; Reject</span>
                                    </label>
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

</x-app-layout>

<!-- Modal -->
<div class="modal fade" id="proposalModal" tabindex="-1" role="dialog" aria-labelledby="proposalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="proposalModalLabel">{{ $project->proposal }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe src="{{ URL::asset('/uploads/proposal/'.$project->proposal) }}" class="col-12" height="400px"></iframe>
            </div>
            <div class="modal-footer bg-whitesmoke">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                <a href="{{ route('project.proposal', $project->id) }}" class="btn btn-icon icon-left btn-primary" type="button"><i class="fas fa-download"></i>Download File</a>
            </div>
        </div>
    </div>
</div>