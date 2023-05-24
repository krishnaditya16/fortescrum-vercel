<x-app-layout>
    <x-slot name="title">{{ __('Edit Expenses') }}</x-slot>
    <x-slot name="header_content">
        <div class="section-header-back">
            <a href="{{ route('project.show', $project->id) }}" class="btn btn-icon"><i
                    class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ __('Edit Expenses') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('project.index') }}">Project</a></div>
            <div class="breadcrumb-item active"><a href="../{{ $project->id }}">#{{ $project->id }}</a></div>
            <div class="breadcrumb-item">Edit Expenses</div>
        </div>
    </x-slot>

    <h2 class="section-title">Edit Expenses Status</h2>
    <p class="section-lead mb-3">
        On this page you can edit existing expenses/spending data.
    </p>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Expenses Status Form</h4>
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
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Project</label>
                        <div class="col-sm-12 col-md-7">                         
                            <input class="form-control" readonly value="{{$project->title}}">
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Description</label>
                        <div class="col-sm-12 col-md-7">
                            <textarea class="form-control" readonly>{{ $expense->description }}</textarea>
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Date</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" class="form-control" value="{{ $expense->expenses_date }}" readonly>
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Ammount</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" class="form-control" value="${{ number_format($expense->ammount) }}" readonly>
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Category</label>
                        <div class="col-sm-12 col-md-7">
                            @if($expense->expenses_category == 0)
                            <input type="text" class="form-control" value="Services" readonly>
                            @elseif($expense->expenses_category == 1)
                            <input type="text" class="form-control" value="Wages" readonly>
                            @elseif($expense->expenses_category == 2)
                            <input type="text" class="form-control" value="Accounting Services" readonly>
                            @elseif($expense->expenses_category == 3)
                            <input type="text" class="form-control" value="Office Supplies" readonly>
                            @elseif($expense->expenses_category == 4)
                            <input type="text" class="form-control" value="Communication" readonly>
                            @elseif($expense->expenses_category == 5)
                            <input type="text" class="form-control" value="Travel" readonly>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Team Member</label>
                        <div class="col-sm-12 col-md-7">
                                @foreach($members as $member)
                                    @if($expense->team_member == $member->id)
                                    <input type="text" class="form-control"  value="{{ $member->name }}" readonly>
                                    @endif
                                @endforeach
                            @error('team_member') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Receipt File</label>
                        <div class="col-sm-12 col-md-7">
                            <button class="btn btn-outline-primary mt-2" data-toggle="modal" data-target="#receiptModal"><i class="fas fa-eye"></i> View File</button>
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status Now</label>
                        <div class="col-sm-12 col-md-7">
                            @if($expense->expenses_status == "0")
                            <div class="badge badge-warning">Pending</div>
                            @elseif($expense->expenses_status == "1")
                            <div class="badge badge-success">Approved</div>
                            @elseif($expense->expenses_status == "2")
                            <div class="badge badge-danger">Rejected</div>
                            @endif
                        </div>
                    </div>

                    <form action="{{ route('project.expenses.status.update', ['id'=>$project->id, 'expense'=>$expense->id]) }}" method="post">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="expenses_id" value="{{ $expense->id }}">
                        <input type="hidden" value="{{$project->id}}" name="project_id">
                        
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Expenses Status</label>
                            <div class="col-sm-12 col-md-7">
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="expenses_status" value="1" class="selectgroup-input">
                                        <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-check"></i> &nbsp; Approve</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="expenses_status" value="2" class="selectgroup-input">
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

    @push('custom-scripts')
    <script>
        var cleaveC = new Cleave('.currency', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand'
        });
    </script>
    @endpush


</x-app-layout>

<!-- Modal -->
<div class="modal fade" id="receiptModal" tabindex="-1" role="dialog" aria-labelledby="receiptModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                @if(empty($expense->receipt))
                    <h5 class="modal-title" id="receiptModalLabel">There is no receipt attached</h5>
                @else
                    <h5 class="modal-title" id="receiptModalLabel">{{ $expense->receipt }}</h5>
                @endif
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if(empty($expense->receipt))
                <span class="badge badge-secondary">Empty</span>
                @else
                <div style="overflow: auto; max-height:400px">
                    <img src="{{ url('/uploads/receipt/'.$expense->receipt) }}" alt="">
                </div>
                @endif
            </div>
            <div class="modal-footer bg-whitesmoke">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
            </div>
        </div>
    </div>
</div>