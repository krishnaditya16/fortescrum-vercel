@php
$users = DB::table('users')->where('id', $client->user_id)->get();
@endphp
@foreach($users as $user)
    @if(is_null($user->profile_photo_path))
        @php
            $name = trim(collect(explode(' ', $user->name))->map(function ($segment) {
            return mb_substr($segment, 0, 1);
            })->join(''));
        @endphp
        <div class="media">
            <figure class="avatar mr-3" data-initial="{{$name}}" data-toggle="tooltip" title="{{ $user->name }}"></figure>
            <div class="media-body">
                <div class="mt-0 font-weight-bold">{{ $user->name }}</div>
                <div class="text-small font-600-bold">{{ $user->email }}</div>
            </div>
        </div>
    @else
    <div class="media">
        <figure class="avatar mr-3">
            <img src="{{ asset('storage/'.$user->profile_photo_path) }}" alt="{{ $user->name }}" data-toggle="tooltip" title="{{ $user->name }}">
        </figure>
        <div class="media-body">
            <div class="mt-0 font-weight-bold">{{ $user->name }}</div>
            <div class="text-small font-600-bold">{{ $user->email }}</div>
        </div>
    </div>
    @endif
@endforeach