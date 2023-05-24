<x-app-layout>
    <x-slot name="title">{{ __('Confirm Payment') }}</x-slot>
    <x-slot name="header_content">
        <div class="section-header-back">
            <a href="{{ route('project.invoice.index', $project->id) }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ __('Confirm Payment') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('project.invoice.index', $project->id) }}">Manage Invoice</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('project.invoice.show', ['id' => $project->id, 'invoice' => $invoice->id]) }}">#INV-{{ $invoice->id }}</a></div>
            <div class="breadcrumb-item">Confirm Payment</div>
        </div>
    </x-slot>

    <h2 class="section-title">Confirm Payment </h2>
    <p class="section-lead mb-3">
        On this page you can confirm invoice payment status.
    </p>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Confirm Payment Form</h4>
                </div>
                <div class="card-body">

                    @error('inv_status')
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
                            <input class="form-control" readonly value="{{$project->title}}" style="background-color: #fdfdff;">
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Invoice</label>
                        <div class="col-sm-12 col-md-7">
                            <input class="form-control" readonly value="#INV-{{$invoice->id}}" style="background-color: #fdfdff;">
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Total Ammount</label>
                        <div class="col-sm-12 col-md-7">
                            <input class="form-control" readonly value="$ {{ number_format($invoice->total_all, 2) }}" style="background-color: #fdfdff;">
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Payment Date</label>
                        <div class="col-sm-12 col-md-7">
                            <input class="form-control" readonly value="{{ date('D, d M Y', strtotime($payment->payment_date)) }}" style="background-color: #fdfdff;">
                        </div>
                    </div>

                    @if($payment->payment_type == 0)
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Proof of Payment</label>
                        <div class="col-sm-12 col-md-7">
                            <a href="{{ route('project.payment.download', ['id' => $project->id, 'invoice' => $invoice->id]) }}" class="btn btn-icon icon-left btn-outline-primary mt-2" type="button"><i class="fas fa-download"></i>Download File</a>
                            <button class="btn btn-outline-primary mt-2" data-toggle="modal" data-target="#paymentFileModal"><i class="fas fa-eye"></i> View File</button>
                        </div>
                    </div>
                    @else
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Stripe Transaction ID
                            <i class="fa fa-question-circle" data-toggle="tooltip" title="" data-original-title="Payment is paid using credit card through Stripe"></i>
                        </label>
                        <div class="col-sm-12 col-md-7">
                            <input class="form-control" readonly value="{{ $payment->transaction_id }}" style="background-color: #fdfdff;">
                        </div>
                    </div>
                    @endif

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status Now</label>
                        <div class="col-sm-12 col-md-7">
                            @if($invoice->inv_status == 4)
                            <div class="badge badge-danger mt-1">REJECTED</div>
                            @elseif($invoice->inv_status == 3)
                            <div class="badge badge-warning mt-1">PENDING</div>
                            @elseif($invoice->inv_status == 2)
                            <div class="badge badge-success mt-1">PAID</div>
                            @elseif($invoice->inv_status == 1)
                            <div class="badge badge-primary mt-1">SENT</div>
                            @elseif($invoice->inv_status == 0)
                            <div class="badge badge-secondary mt-1">DRAFT</div>
                            @endif

                            @if(Carbon\Carbon::today()->gt($invoice->deadline) && $invoice->inv_status == "3")
                            <div class="badge badge-danger">OVERDUE</div>
                            @endif
                        </div>
                    </div>

                    <form action="{{ route('project.invoice.confirm.update', ['id' => $project->id, 'invoice' => $invoice->id]) }}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Project Status</label>
                            <div class="col-sm-12 col-md-7">
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="inv_status" value="2" class="selectgroup-input">
                                        <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-check"></i> &nbsp; Confirm</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="inv_status" value="4" class="selectgroup-input">
                                        <span class="selectgroup-button"><i class="fas fa-times"></i> &nbsp; Reject</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Reason
                                <i class="fa fa-question-circle" data-toggle="tooltip" title="" data-original-title="Add reason if payment is rejected"></i>
                            </label>
                            <div class="col-sm-12 col-md-7">
                                <textarea class="form-control summernote-simple" name="reason">{{ old('reason') }}</textarea>
                                @error('reason') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                        <input type="hidden" name="project_id" value="{{ $project->id }}">

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
<div class="modal fade" id="paymentFileModal" tabindex="-1" role="dialog" aria-labelledby="paymentFileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentFileModalLabel">#INV-{{ $invoice->id }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe src="{{ URL::asset('/uploads/invoice-payment/'.$payment->invoice_payment) }}" class="col-12" height="400px"></iframe>
            </div>
            <div class="modal-footer bg-whitesmoke">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                <a href="{{ route('project.payment.download', ['id' => $project->id, 'invoice' => $invoice->id]) }}" class="btn btn-icon icon-left btn-primary" type="button"><i class="fas fa-download"></i>Download File</a>
            </div>
        </div>
    </div>
</div>