@php
    $arr = $value;
    $assignee = explode(",",$arr);
    $users = DB::table('users')->whereIn('id', $assignee)->get();
@endphp

@foreach ($users as $user)
    @if(is_null($user->profile_photo_path))
        @php
            $name = trim(collect(explode(' ', $user->name))->map(function ($segment) {
                return mb_substr($segment, 0, 1);
            })->join(''));
        @endphp

    <figure class="avatar" data-initial="{{$name}}" data-toggle="tooltip" title="{{ $user->name }}"></figure>
    
    @else
    
    <figure class="avatar">
        <img src="{{ asset('storage/'.$user->profile_photo_path) }}" alt="{{ $user->name }}" data-toggle="tooltip" title="{{ $user->name }}">
    </figure>

    @endif

@endforeach