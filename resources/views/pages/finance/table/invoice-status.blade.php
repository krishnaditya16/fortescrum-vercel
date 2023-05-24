@if($row->inv_status == "0")
    <div class="badge badge-light">Draft</div>
@elseif($row->inv_status == "1")
    <div class="badge badge-primary">Sent</div>
@elseif($row->inv_status == "2")
    <div class="badge badge-success">Paid</div>
@elseif($row->inv_status == "3")
    <div class="badge badge-warning">Pending Confirmation</div>
@elseif($row->inv_status == "4")
    <div class="badge badge-danger">Rejected</div>
@endif

@if(Carbon\Carbon::today()->gt($row->deadline) && $row->inv_status == "0")
    <div class="badge badge-danger">Overdue</div>
@elseif(Carbon\Carbon::today()->gt($row->deadline) && $row->inv_status == "1")
    <div class="badge badge-danger">Overdue</div>
@endif
