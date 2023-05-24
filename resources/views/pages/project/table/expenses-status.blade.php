@if($value == "0")
<div class="badge badge-warning">Pending</div>
@elseif($value == "1")
<div class="badge badge-success">Approved</div>
@elseif($value == "2")
<div class="badge badge-danger">Rejected</div>
@endif