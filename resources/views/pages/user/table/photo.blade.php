@if(!is_null($value))
<img class="h-10 w-10 rounded-full" src="{{ $value->profile_photo_url }}" alt="{{ $value->name }}" data-toggle="tooltip" title="{{ $value->name }}"/>
@else
<img class="w-8 h-8 rounded-full" src="/storage/{{ $value->profile_photo_path }}" data-toggle="tooltip" title="{{ $value->name }}"/>
@endif
