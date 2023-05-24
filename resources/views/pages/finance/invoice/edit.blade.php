<x-app-layout>
    <x-slot name="title">{{ __('Edit Invoice') }}</x-slot>
    <x-slot name="header_content">
        <div class="section-header-back">
            <a href="{{ url()->previous() }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ __('Edit Invoice') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('backlog.index') }}">Invoice</a></div>
            <div class="breadcrumb-item">Edit</div>
        </div>
    </x-slot>

    <h2 class="section-title">Edit Invoice </h2>
    <p class="section-lead mb-3">
        On this page you can edit existing invoice data.
    </p>


    <div class="row">
        <div class="col-12">

            <form action="{{ route('project.invoice.update', $invoice->project_id) }}" method="post">
                @csrf
                @method('PUT')

                <div class="invoice">
                    <div class="invoice-print">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="invoice-title">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="title-invoice">Invoice</div>
                                            <p class="text-muted">#INV-{{ $invoice->id }}</p>
                                        </div>
                                        <div class="col-6 text-right">
                                            <p style="font-size: 2rem" class="text-muted invoice-status">DRAFT</p>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h1 class="text-muted mb-2">PROJECT</h1>
                                        <p>This invoice is related to : <b>{{ $project->title }}</b></p>
                                        <input type="hidden" name="project_id" value="{{ $project->id }}">
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <address>
                                            <h1 class="text-muted mb-2">FROM</h1>
                                            <input class="form-control mb-2" type="text" name="company_name"
                                                placeholder="Your Company Name" value="{{ $invoice->company_name }}">
                                            <input class="form-control mb-2" type="text" name="company_address"
                                                placeholder="Your Company Address" value="{{ $invoice->company_address }}">
                                        </address>
                                    </div>
                                    <div class="col-md-6">
                                        <address>
                                            <h1 class="text-muted mb-2">TO</h1>
                                            <input class="form-control mb-2" type="text" name=""
                                                value="{{ $client->name }}" readonly>
                                            <input class="form-control mb-2" type="text" name=""
                                                value="{{ $client->address }}" readonly>
                                            <input type="hidden" name="client_id" value="{{ $client->id }}">
                                        </address>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <address>
                                            <h1 class="text-muted mb-2">ISSUED DATE</h1>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-calendar"></i>
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control datepicker" name="issued" value="{{ $invoice->issued }}">
                                            </div>
                                            @error('issued') <span class="text-red-500">{{ $message }}</span>@enderror
                                        </address>
                                    </div>
                                    <div class="col-md-6">
                                        <address>
                                            <h1 class="text-muted mb-2">DUE DATE</h1>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-calendar"></i>
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control datepicker" name="deadline" value="{{ $invoice->deadline }}">
                                            </div>
                                            @error('deadline') <span class="text-red-500">{{ $message }}</span>@enderror
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
                                    <table class="table table-bordered table-md" id=invoiceTable>
                                        <thead>
                                            <tr>
                                                <th class="text-center pt-2">
                                                    <i class="fas fa-check"></i>
                                                </th>
                                                <th>
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
                                            <td class="text-center pt-2">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" class="form-check-input check-task inv-border" 
                                                    name="task_id[]" value="{{ $task->id }}" onchange="calcTask()"
                                                    {{ in_array($task->id, $task_id) ? 'checked' : '' }} >
                                                </div>
                                            </td>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $task->title }}</td>
                                            <td>
                                                <input type="number" name="rate_task[]" placeholder="Rate" value="{{ $rate_task[$key] }}"
                                                min="1" class="form-control num-input" onkeyup="calcTask()" />
                                                @error('rate_task[]') <span class="text-red-500">{{ $message }}</span>@enderror
                                            </td>
                                            <td>
                                                <input type="text" name="qty_task[]" placeholder="Qty" value="{{ $qty_task[$key] }}"
                                                min="1" class="form-control num-input" onkeyup="calcTask()" />
                                                @error('qty_task[]') <span class="text-red-500">{{ $message }}</span>@enderror
                                            </td>
                                            <td>
                                                <input type="text" placeholder="Total" name="total_task[]" value="{{ $total_task[$key] }}"
                                                class="form-control total-task" onkeyup="calcTask();"/>
                                                @error('total_task[]') <span class="text-red-500">{{ $message }}</span>@enderror
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6">
                                                <p class="text-danger text-center">No Data Found</p> 
                                            </td>
                                        </tr>
                                        @endforelse
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5" align="right"><b>Subtotal</b></td>
                                                <td>$<input id="subtotal_task" name="subtotal_task"  onkeyup="calcTask()" value="{{ $invoice->subtotal_task }}" readonly/></td>
                                                @error('subtotal_ts') <span class="text-red-500">{{ $message }}</span>@enderror
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="section-title">Timesheets Summary</div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-md" id=TableTS>
                                        <thead>
                                            <tr>
                                                <th class="text-center pt-2">
                                                    <i class="fas fa-check"></i>
                                                </th>
                                                <th>
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
                                            <td class="text-center pt-2">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" class="form-check-input check-ts inv-border" 
                                                    name="time_id[]" value="{{ $timesheet->id }}" onchange="calcTS()"
                                                    {{ in_array($timesheet->id, $time_id) ? 'checked' : '' }} >
                                                    {{-- @if(count($time_id) == 1)
                                                        <input type="checkbox" class="form-check-input check-ts inv-border" 
                                                        name="time_id[]" value="{{ $timesheet->id }}" onchange="calcTS()"
                                                        {{ $timesheet->id == $invoice->timesheet_id ? 'checked' : '' }} >
                                                    @else
                                                        <input type="checkbox" class="form-check-input check-ts inv-border" 
                                                        name="time_id[]" value="{{ $timesheet->id }}" onchange="calcTS()"
                                                        {{ $timesheet->id == $time_id[$key] ? 'checked' : '' }} >
                                                    @endif --}}
                                                </div>
                                            </td>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>Task : {{ $timesheet->tasks->title }} - Timesheets ID : #{{ $timesheet->id }}</td>
                                            <td>
                                                <input type="text" name="rate_ts[]" placeholder="Rate" value="{{ $rate_ts[$key] }}"
                                                min="1" class="form-control num-input" onkeyup="calcTS()" />
                                                @error('rate_ts[]') <span class="text-red-500">{{ $message }}</span>@enderror
                                            </td>
                                            <td>
                                                @php
                                                $startTime = Carbon\Carbon::parse($timesheet->start_time);
                                                $endTime = Carbon\Carbon::parse($timesheet->end_time);
                                                $interval = $endTime->diff($startTime)->format('%H:%I:%S');

                                                $timestamp = strtotime($interval); 
                                                @endphp
                                                <input type="text" value="{{ $interval }}" name="qts" class="form-control" style="background-color: #fdfdff" readonly/>
                                                <input type="hidden" name="quantity_ts" value="{{ (idate('i', $timestamp))/60 }}"  onkeyup="calcTS()" />
                                                <input type="hidden" name="qty_ts[]" value="{{ $qty_ts[$key] }}" class="qty_ts" />
                                            </td>
                                            <td>
                                                <input type="text" name="total_ts[]" value="{{ $total_ts[$key] }}"
                                                placeholder="Total" class="form-control total-ts" onkeyup="calcTS();"/>
                                                @error('total_ts[]') <span class="text-red-500">{{ $message }}</span>@enderror
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6">
                                                <p class="text-danger text-center">No Data Found</p> 
                                            </td>
                                        </tr>
                                        @endforelse
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5" align="right"><b>Subtotal</b></td>
                                                <td>$<input id="subtotal_ts" name="subtotal_ts" onkeyup="calcTS()" value="{{ $invoice->subtotal_ts }}" readonly/></td>
                                                @error('subtotal_ts') <span class="text-red-500">{{ $message }}</span>@enderror
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="section-title">Expenses Summary</div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-md" id=invoiceTable>
                                        <thead>
                                            <tr>
                                                <th class="text-center pt-2" style="width:55px">
                                                    <i class="fas fa-check"></i>
                                                </th>
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
                                                <td class="text-center pt-2">
                                                    <div class="custom-checkbox custom-control">
                                                        <input type="checkbox" class="form-check-input check-exp inv-border" 
                                                        name="exp_id[]" value="{{ $expense->id }}" onchange="calcExp()"
                                                        {{ in_array($expense->id, $exp_id) ? 'checked' : '' }} >
                                                        {{-- @if(count($time_id) == 1)
                                                            <input type="checkbox" class="form-check-input check-exp inv-border" 
                                                            name="exp_id[]" value="{{ $expense->id }}" onchange="calcExp()"
                                                            {{ $expense->id == $invoice->expenses_id ? 'checked' : '' }} >
                                                        @else
                                                            <input type="checkbox" class="form-check-input check-exp inv-border" 
                                                            name="exp_id[]" value="{{ $expense->id }}" onchange="calcExp()"
                                                            {{ $expense->id == $exp_id[$key] ? 'checked' : '' }}>
                                                        @endif --}}
                                                    </div>
                                                </td>
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
                                                <td>${{ $expense->ammount }}</td>
                                                <input type="hidden" name="expenses[]" value="{{ $expense->ammount }}">
                                                <input type="hidden" name="exp_ammount[]" value="{{ $exp_ammount[$key] }}" class="exp-ammount">
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
                                                <td>$<input id="subtotal_expenses" name="subtotal_exp" onkeyup="calcExp()" value="{{ $invoice->subtotal_exp }}" readonly/></td>
                                                @error('subtotal_exp') <span class="text-red-500">{{ $message }}</span>@enderror
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-lg-12 text-right">
                                <hr class="mt-2 mb-2">

                                <div class="invoice-detail-item">
                                    <div class="invoice-detail-name">Tax</div>
                                    <div style="display: inline-flex">
                                        <span class="invoice-detail-value border-text mr-1">%</span>
                                        <input class="invoice-detail-value form-invoice num-input" 
                                            type="text" name="tax_percent" id="tax" value="{{ $invoice->tax_percent }}"
                                            onkeyup="totalAll()" value="0" placeholder="tax"/>
                                    </div>
                                </div>
                                <div class="invoice-detail-item">
                                    <div class="invoice-detail-name">Tax Ammount</div>
                                    <div style="display: inline-flex">
                                        <span class="invoice-detail-value border-text mr-1">$</span>
                                        <input class="invoice-detail-value form-invoice" value="{{ $invoice->tax_ammount }}"
                                        name="tax_ammount" type="text" id="tax_detail" value="0" readonly/>
                                    </div>
                                </div>

                                <div class="invoice-detail-item">
                                    <div class="invoice-detail-name">Discount</div>
                                    <div style="display: inline-flex">
                                        <span class="invoice-detail-value border-text mr-1">%</span>
                                        <input class="invoice-detail-value form-invoice num-input" 
                                            type="text" name="discount_percent" id="discount" value="{{ $invoice->discount_percent }}"
                                            min="1" max="100" onkeyup="totalAll()" value="0" placeholder="discount"/>
                                    </div>
                                </div>
                                <div class="invoice-detail-item">
                                    <div class="invoice-detail-name">Discount Ammount</div>
                                    <div style="display: inline-flex">
                                        <span class="invoice-detail-value border-text mr-1">$</span>
                                        <input class="invoice-detail-value form-invoice" value="{{ $invoice->discount_ammount }}"
                                        name="discount_ammount" type="text" id="discount_detail" value="0" readonly/>
                                    </div>
                                </div>

                                <div class="invoice-detail-item">
                                    <div class="invoice-detail-name">Total</div>
                                    <div style="display: inline-flex">
                                        <span class="invoice-detail-value border-text mr-1">$</span>
                                        <input style="background-color: #fdfdff" 
                                            class="invoice-detail-value form-invoice" value="{{ $invoice->total_all }}"
                                            placeholder="total" type="number" name="total_all" id="total_all" readonly>
                                    </div>
                                </div>
                                @error('total_all') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                    </div>
                    <hr>
                    <div class="text-md-right">
                        <button type="submit" class="btn btn-primary btn-icon icon-left">
                            <i class="fas fa-file-alt"></i>
                            Update Invoice
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </div>

    @push('custom-scripts')
        <script src="{{ asset('stisla/js/invoice-scripts.js') }}"></script>
    @endpush

</x-app-layout>