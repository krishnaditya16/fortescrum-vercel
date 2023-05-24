@php 
$meeting = DB::table('meetings')->where('id', $type->id)->first();
@endphp
@if($meeting->type == "0")
<div class="row">
    <div class="col-12 col-md-3">
        <div class="badge badge-light mt-3">Offline</div>
    </div>
    <div class="col-12 col-md-9 ml-1">
        <h4 class="mt-2">Location</h4>
        <p class="mb-2">{{$meeting->meeting_location}}</p>
    </div>
</div>


@elseif($meeting->type == "1")
<div class="row">
    <div class="col-12 col-md-3">
        <div class="badge badge-secondary mt-3">Online</div>
    </div>
    <div class="col-12 col-md-9 ml-1">
        <h4 class="mt-2 mb-2">URL : <a href="{{$meeting->meeting_link}}">Link</a></h4>
    </div>
</div>
@endif

