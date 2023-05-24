<x-app-layout>
    <x-slot name="title">{{ __('Edit Invoice Payment') }}</x-slot>
    <x-slot name="header_content">
        <div class="section-header-back">
            <a href="{{ route('project.invoice.index', $project->id) }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ __('Edit Invoice Payment') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('project.invoice.index', $project->id) }}">Manage Invoice</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('project.invoice.show', ['id' => $project->id, 'invoice' => $invoice->id]) }}">#INV-{{ $invoice->id }}</a></div>
            <div class="breadcrumb-item">Edit Invoice Payment</div>
        </div>
    </x-slot>

    <h2 class="section-title">Edit Invoice Payment </h2>
    <p class="section-lead mb-3">
        On this page you can edit your payment proof/receipt for selected invoice.
    </p>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Invoice Payment Form</h4>
                </div>
                <div class="card-body">

                    <form action="{{ route('project.invoice.payment.update', ['id' => $project->id, 'invoice' => $invoice->id]) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Project</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="hidden" value="{{ $project->id }}" name="project_id">
                                <input class="form-control" readonly value="{{$project->title}}">
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Invoice</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="hidden" value="{{ $invoice->id }}" name="invoice_id">
                                <input class="form-control" readonly value="#INV-{{$invoice->id}}">
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Total Ammount</label>
                            <div class="col-sm-12 col-md-7">
                                <input class="form-control" readonly value="$ {{ number_format($invoice->total_all, 2) }}">
                            </div>
                        </div>

                        @if($invoice->inv_status == 4)
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Reason</label>
                            <div class="col-sm-12 col-md-7">
                                <input class="form-control" readonly value="{{ $payment->reason }}">
                                @error('notes') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        @endif

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Payment Date</label>
                            <div class="col-sm-12 col-md-7">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control datepicker" name="payment_date" value="{{ $payment->payment_date }}">
                                </div>
                                @error('payment_date') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        {{-- <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Payment Method</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control select2" name="payment_type" id="paymentMethod">
                                    <option selected disabled> Select Type </option>
                                    <option value="0" @if($payment->payment_type == 0) selected="selected" @endif>Bank Transfer</option>
                                    <option value="1" @if($payment->payment_type == 1) selected="selected" @endif>Cash</option>
                                </select>
                                @error('payment_type') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4" id="transactionID" style="display: none">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Transaction ID</label>
                            <div class="col-sm-12 col-md-7">
                                @if(empty($payment->transaction_id))
                                    <input class="form-control" name="transaction_id" id="transaction_id">
                                @else
                                    <input class="form-control" name="transaction_id" id="transaction_id" value="{{ $payment->transaction_id }}">
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Proof of Payment</label>
                            <div class="col-sm-12 col-md-7">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFileInput" name="invoice_payment"
                                        aria-describedby="customFileInput" value="{{ old('invoice_payment') }}">
                                    <label class="custom-file-label" for="customFileInput">{{ $payment->invoice_payment }}</label>
                                    <small class="form-text text-muted mt-3">
                                        File format are PDF / JPG / PNG, and file size must be below 2 Mb.
                                    </small>
                                    @error('invoice_payment') <span class="text-red-500">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div> --}}

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Payment Method</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control select2" name="payment_type" id="paymentMethod">
                                    <option selected disabled> Select Type </option>
                                    <option value="0" @if($payment->payment_type == 0) selected="selected" @endif>Bank Transfer</option>
                                    <option value="1" @if($payment->payment_type == 1) selected="selected" @endif>Credit Card</option>
                                </select>
                                @error('payment_type') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4" id="transactionID" style="display: none">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Transaction ID</label>
                            <div class="col-sm-12 col-md-7">
                                @if(empty($payment->transaction_id))
                                    <input class="form-control" name="transaction_id" id="transaction_id">
                                @else
                                    <input class="form-control" name="transaction_id" id="transaction_id" value="{{ $payment->transaction_id }}">
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-4" id="proofPayment" style="display: none">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Proof of Payment</label>
                            <div class="col-sm-12 col-md-7">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFileInput" name="invoice_payment"
                                        aria-describedby="customFileInput" value="{{ old('invoice_payment') }}">
                                    <label class="custom-file-label" for="customFileInput">Choose file</label>
                                    <small class="form-text text-muted mt-3">
                                        File format are PDF / JPG / PNG, and file size must be below 2 Mb.
                                    </small>
                                    @error('invoice_payment') <span class="text-red-500">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="" id="stripePayment" style="display: none">
                            <div class="form-group row mb-4">
                                <label for="credit_card_name" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Full name (On the card)</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control" name="credit_card_name" placeholder="Full Name" id="card_name">
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label for="credit_card_number" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Card number</label>
                                <div class="col-sm-12 col-md-7">
                                    <div class="input-group">
                                        <input type="text" class="form-control creditcard" name="credit_card_number" placeholder="Card Number" id="card_number">
                                        <div class="input-group-append">
                                            <span class="input-group-text text-muted">
                                            <i class="fab fa-cc-visa fa-lg pr-1"></i>
                                            <i class="fab fa-cc-amex fa-lg pr-1"></i>
                                            <i class="fab fa-cc-mastercard fa-lg"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Expiration Month/Year</label>
                                <div class="col-sm-12 col-md-7">
                                    <div class="input-group">
                                        <select class="form-control" name="credit_card_expiry_month" id="card_exp_month">
                                            <option disabled>MM</option>
                                            @foreach(range(1, 12) as $month)
                                                <option value="{{$month}}">{{$month}}</option>
                                            @endforeach
                                        </select>
                                        <select class="form-control" name="credit_card_expiry_year" id="card_exp_year">
                                            <option disabled>YYYY</option>
                                            @foreach(range(date('Y'), date('Y') + 10) as $year)
                                                <option value="{{$year}}">{{$year}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label for="credit_card_number" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">CVC 
                                    <i class="fa fa-question-circle" data-toggle="tooltip" title="" data-original-title="3 digits code on back side of the card"></i>
                                </label> 
                                <div class="col-sm-12 col-md-7">
                                    <input type="number" class="form-control" placeholder="CVC" name="credit_card_cvc" id="card_cvc">
                                </div>
                            </div>
                            
                        </div>

                        <div class="form-group row mb-0">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Notes</label>
                            <div class="col-sm-12 col-md-7">
                                <textarea class="form-control summernote-simple" name="notes">{{ $payment->notes }}</textarea>
                                @error('notes') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <input type="hidden" value="{{ $payment->id }}" name="payment_id">

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7 mt-2">
                                <button type="submit" class="btn btn-primary">Update Payment</button>
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
    @endpush

</x-app-layout>