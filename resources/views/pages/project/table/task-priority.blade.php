@if($value == "0")
<div class="badge badge-info">Normal</div>
@elseif($value == "1")
<div class="badge badge-warning">High</div>
@elseif($value == "2")
<div class="badge badge-danger">Urgent</div>
@elseif($value == "3")
<div class="badge badge-light">Low</div>
@endif



