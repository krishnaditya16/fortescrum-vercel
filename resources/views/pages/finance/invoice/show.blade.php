<x-app-layout>
    <x-slot name="title">{{ __('View Invoice') }} #INV-{{ $invoice->id }}</x-slot>
    <x-slot name="header_content">
        <div class="section-header-back">
            <a href="{{ url()->previous() }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ __('View Invoice') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('project.invoice.index', $project->id) }}">Invoice</a></div>
            <div class="breadcrumb-item">#INV-{{ $invoice->id }}</div>
        </div>
    </x-slot>

    <h2 class="section-title">View Invoice</h2>
    <p class="section-lead mb-3">
        On this page you can view information regarding invoice data you selected.
    </p>

    <div class="row">
        <div class="col-12">

            <div class="invoice">
                <div class="invoice-print" id="invoice-print">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="invoice-title">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="title-invoice">Invoice</div>
                                        <p class="text-muted" id="invoice-id">#INV-{{ $invoice->id }}</p>
                                    </div>
                                    <div class="col-6 text-right" id="invoice-status">
                                        @if(Carbon\Carbon::today()->gt($invoice->deadline) && $invoice->inv_status == 0 || $invoice->inv_status == 1)
                                        <p class="text-danger invoice-status">OVERDUE</p>
                                        @elseif($invoice->inv_status == 4)
                                        <p class="text-danger invoice-status">REJECTED</p>
                                        @elseif($invoice->inv_status == 3)
                                        <p class="text-warning invoice-status">PENDING</p>
                                        @elseif($invoice->inv_status == 2)
                                        <p class="text-success invoice-status">PAID</p>
                                        @elseif($invoice->inv_status == 1)
                                        <p class="text-primary invoice-status">SENT</p>
                                        @elseif($invoice->inv_status == 0)
                                        <p class="text-muted invoice-status">DRAFT</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h1 class="text-muted mt-4 mb-2">PROJECT</h1>
                                    <p id="invoice-project">This invoice is related to : <b>{{ $project->title }}</b></p>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <address>
                                        <h1 class="text-muted mb-2">FROM</h1>
                                        <p id="invoice-company"><strong>{{ $invoice->company_name }}</strong></p>
                                        <p id="invoice-address">{{ $invoice->company_address }}</p>
                                    </address>
                                </div>
                                <div class="col-md-6">
                                    <address>
                                        <h1 class="text-muted mb-2">TO</h1>
                                        <p id="invoice-client"><strong>{{ $client->name }}</strong></p>
                                        <p id="invoice-client-address">{{ $client->address }}</p>
                                    </address>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <address>
                                        <h1 class="text-muted mb-2">ISSUED DATE</h1>
                                        <p id="invoice-issued"><strong>{{ date('D, d M Y', strtotime($invoice->issued)) }}</strong></p>
                                    </address>
                                </div>
                                <div class="col-md-6">
                                    <address>
                                        <h1 class="text-muted mb-2">DUE DATE</h1>
                                        <p id="invoice-deadline"><strong>{{ date('D, d M Y', strtotime($invoice->deadline)) }}</strong></p>
                                    </address>
                                </div>
                            </div>

                        </div>
                    </div>
                    <hr>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="section-title">Tasks Summary</div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-md" id="invoice-task-table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                <i class="fas fa-hashtag"></i>
                                            </th>
                                            <th style="width:35%">Description</th>
                                            <th>Rate/Unit</th>
                                            <th>Qty</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($tasks as $key => $task)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $task->title }}</td>
                                        <td>${{ $rate_task[$key] }}</td>
                                        <td>{{ $qty_task[$key] }}</td>
                                        <td>${{ $total_task[$key] }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5">
                                            <p class="text-danger text-center">No Data Found</p> 
                                        </td>
                                    </tr>
                                    @endforelse
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4" align="right"><b>Subtotal</b></td>
                                            <td>${{ $invoice->subtotal_task }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="section-title">Timesheets Summary</div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-md" id="invoice-timesheet-table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                <i class="fas fa-hashtag"></i>
                                            </th>
                                            <th style="width:35%">Description</th>
                                            <th>Rate/Hour</th>
                                            <th>Qty</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($timesheets as $key => $timesheet)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>Task : {{ $timesheet->tasks->title }} - Timesheet ID : #{{ $timesheet->id }}</td>
                                        <td>${{ $rate_ts[$key] }}</td>
                                        <td>{{ $qty_ts[$key] }}</td>
                                        @php
                                            $timestamp = strtotime($qty_ts[$key]); 
                                        @endphp
                                        <td>${{ $total_ts[$key] }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5">
                                            <p class="text-danger text-center">No Data Found</p> 
                                        </td>
                                    </tr>
                                    @endforelse
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4" align="right"><b>Subtotal</b></td>
                                            <td>${{ $invoice->subtotal_ts }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="section-title">Expenses Summary</div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-md" id="invoice-expense-table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                <i class="fas fa-hashtag"></i>
                                            </th>
                                            <th style="width:35%">Description</th>
                                            <th>Category</th>
                                            <th>Ammount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($expenses as $key => $expense)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $expense->description }}</td>
                                        <td>
                                            @if($expense->expenses_category == '0')
                                                Services
                                            @elseif($expense->expenses_category == '1')
                                                Wages
                                            @elseif($expense->expenses_category == '2')
                                                Accounting Services
                                            @elseif($expense->expenses_category == '3')
                                                Office Supplies
                                            @elseif($expense->expenses_category == '4')
                                                Communication
                                            @elseif($expense->expenses_category == '5')
                                                Travel
                                            @endif
                                        </td>
                                        <td>${{ $exp_ammount[$key] }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4">
                                            <p class="text-danger text-center">No Data Found</p> 
                                        </td>
                                    </tr>
                                    @endforelse
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" align="right"><b>Subtotal</b></td>
                                            <td>${{ $invoice->subtotal_exp}}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="row mt-4">
                                <div class="col-lg-12 text-right">
                                    <hr class="mt-2 mb-2">
                                    <div class="invoice-detail-item" id="invoice-tax">
                                        <div class="invoice-detail-name">Tax</div>
                                        @if(empty($invoice->tax_ammount))
                                            <div class="invoice-detail-value">$0</div>
                                        @else
                                            <div class="invoice-detail-value">${{ $invoice->tax_ammount }} ({{ $invoice->tax_percent }}%)</div>
                                        @endif
                                    </div>
                                    <div class="invoice-detail-item" id="invoice-discount">
                                        <div class="invoice-detail-name">Discount</div>
                                        @if(empty($invoice->discount_ammount))
                                            <div class="invoice-detail-value">$0</div>
                                        @else
                                            <div class="invoice-detail-value">${{ $invoice->discount_ammount }} ({{ $invoice->discount_percent }}%)</div>
                                        @endif
                                    </div>
                                    <div class="invoice-detail-item" id="invoice-total">
                                        <div class="invoice-detail-name">Total</div>
                                        <div class="invoice-detail-value invoice-detail-value-lg">${{ $invoice->total_all }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if(Auth::user()->hasTeamRole($team, 'client-user') && !Auth::user()->ownsTeam($team))
                <div class="text-md-right">
                    <div class="float-lg-left mb-lg-0 mb-3">
                        @if($invoice->inv_status == 0 || $invoice->inv_status == 1)
                            <a href="{{ route('project.invoice.payment', ['id' => $project->id, 'invoice' => $invoice->id]) }}" class="btn btn-primary btn-icon icon-left"><i class="fas fa-credit-card"></i> Process Payment</a>
                        @endif     
                    </div>
                    <button class="btn btn-warning btn-icon icon-left" onclick="printContent('invoice-print')" id="invoice-print-button"><i class="fas fa-print"></i> Print</button>
                </div>
                @else
                <div class="text-md-right">
                    <button class="btn btn-warning btn-icon icon-left" onclick="printContent('invoice-print')" id="invoice-print-button"><i class="fas fa-print"></i> Print</button>
                </div>
                @endif
            </div>
        </div>
    </div>

    @push('custom-scripts')
        <script src="{{ asset('stisla/js/shepherd/invoice-tour.js') }}"></script>
    @endpush

</x-app-layout>