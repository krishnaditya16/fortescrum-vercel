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

    <h2 class="section-title">Edit Expenses </h2>
    <p class="section-lead mb-3">
        On this page you can edit existing expenses/spending data.
    </p>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Expenses</h4>
                </div>
                <div class="card-body">

                    <form action="{{ route('project.expenses.update', ['id'=>$project->id, 'expense'=>$expense->id]) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Project</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="hidden" value="{{$project->id}}" name="project_id">
                                <input class="form-control" readonly value="{{$project->title}}">
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Description</label>
                            <div class="col-sm-12 col-md-7">
                                <textarea class="form-control" name="description">{{ $expense->description }}</textarea>
                                @error('description') <span class="text-red-500">{{ $message }}</span>@enderror
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
                                    <input type="text" class="form-control datepicker" name="expenses_date" value="{{ $expense->expenses_date }}">
                                </div>
                                @error('expenses_date') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Ammount</label>
                            <div class="col-sm-12 col-md-7">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">$</div>
                                    </div>
                                    <input type="text" class="form-control currency" name="ammount" value="'{{ $expense->ammount }}'">
                                </div>
                                @error('ammount') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Category</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control select2" name="expenses_category">
                                    <option selected disabled> Select Category </option>
                                    <option value="0" @if($expense->expenses_category == 0) selected="selected" @endif>Services</option>
                                    <option value="1" @if($expense->expenses_category == 1) selected="selected" @endif>Wages</option>
                                    <option value="2" @if($expense->expenses_category == 2) selected="selected" @endif>Accounting Services</option>
                                    <option value="3" @if($expense->expenses_category == 3) selected="selected" @endif>Office Supplies</option>
                                    <option value="4" @if($expense->expenses_category == 4) selected="selected" @endif>Communication</option>
                                    <option value="5" @if($expense->expenses_category == 5) selected="selected" @endif>Travel</option>
                                </select>
                                @error('expenses_category') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Team Member</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control select2" name="team_member">
                                    <option selected disabled> Select Team Member </option>
                                    @foreach($members as $member)
                                    <option value="{{ $member->id }}" @if($expense->team_member == $member->id) selected="selected" @endif>{{ $member->name }}</option>
                                    @endforeach
                                </select>
                                @error('team_member') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-2">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Receipt</label>
                            <div class="col-sm-12 col-md-7">
                                <label class="custom-switch mt-2">
                                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input btn-receipt">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Attach A Receipt</span>
                                </label>
                            </div>
                        </div> 

                        <div class="form-group row" id="receipt_toggle" style="display: none;">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <div class="row">
                                    <div class="col-12 col-md-9">
                                        <div id="image-preview" class="image-preview" style="width: auto">
                                            <label for="image-upload" id="image-label">Choose File</label>
                                            <input type="file" name="receipt" id="image-upload">
                                        </div>
                                        <small class="form-text text-muted mt-2 mb-2">File format are JPG or PNG, and file size must be below 2 Mb.</small>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <h4>Previous Receipt</h4>
                                        <a href="" class="btn btn-outline-primary mt-2" data-toggle="modal" data-target="#receiptModal"><i class="fas fa-eye"></i> View File</a>
                                    </div>
                                </div>
                            </div>
                        </div> 

                        <input type="hidden" name="expenses_id" value="{{ $expense->id }}">

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7 mt-2">
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

    <script>
        $.uploadPreview({
            input_field: "#image-upload", // Default: .image-upload
            preview_box: "#image-preview", // Default: .image-preview
            label_field: "#image-label", // Default: .image-label
            label_default: "Choose File", // Default: Choose File
            label_selected: "Change File", // Default: Change File
            no_label: false, // Default: false
            success_callback: null, // Default: null
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