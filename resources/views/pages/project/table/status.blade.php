@if($row->status == "0")
    <div class="badge badge-secondary">Waiting Approval</div>
@elseif($row->status == "1")
    <div class="badge badge-danger">Rejected</div>
@elseif($row->status == "2")
    <div class="badge badge-info">In Progress</div>
@elseif($row->status == "3")
    <div class="badge badge-success">Completed</div>
@elseif($row->status == "4")
    <div class="badge badge-warning">On Hold</div>
@elseif($row->status == "5")
    <div class="badge badge-danger">Cancelled</div>
@endif

@if(Carbon\Carbon::today()->gt($row->end_date) && $row->status == "2")
    <div class="badge badge-danger">Overdue</div>
@endif


