@php
$team = Auth::user()->currentTeam->id;
$user = Auth::user()->id;
$messages = App\Models\ChMessage::where('to_id', $user)->where('seen', 0)->get();
$count = count($messages);
@endphp
<li class="dropdown dropdown-list-toggle pr-3">
    <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg @if($count != 0) beep @endif">
        <i class="far fa-envelope"></i>
        @if($count != 0)
        <span class="badge badge-notification">{{$count}}</span>
        @endif
    </a>
    <div class="dropdown-menu dropdown-list dropdown-menu-right">
        <div class="dropdown-header">Messages
            @if($count != 0)
            <div class="float-right">
                <form action="{{ route('message.read.all') }}" method="post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="message_id" value="{{ implode(',', $messages->pluck('id')->toArray()) }}">
                    <a href="javascript:void(0)" class="notif-read">Mark All As Read</a>
                </form>
            </div>
            @endif
        </div>
        <div class="dropdown-list-content dropdown-list-message">
            @forelse($messages as $message)
            @php
                $sender = App\Models\User::findOrFail($message->from_id);
            @endphp
            <form action="{{ route('message.read') }}" method="post">
                @csrf
                @method('PUT')
                <input type="hidden" name="message_id" value="{{ $message->id }}">
                <a href="javascript:void(0)" class="dropdown-item dropdown-item-unread message-read" data-toggle="tooltip" title="Click to dismiss message!">
                    <div class="dropdown-item-avatar">
                        <img alt="image" src="{{ $sender->profile_photo_url }}" class="rounded-circle">
                    </div>
                    <div class="dropdown-item-desc">
                        <b>{{ $sender->name }}</b>
                        <p>{!! html_entity_decode($message->body) !!}</p>
                        <div class="time">{{ $sender->updated_at->diffForHumans() }}</div>
                    </div>
                </a>
            </form>
            @empty
            <a href="#" class="dropdown-item dropdown-item-unread">
                <div class="dropdown-item-desc align-item-center">
                    You have no new messages!
                    <div class="time text-primary">Now</div>
                </div>
            </a>
            @endforelse
        </div>
        <div class="dropdown-footer text-center">
            <a href="{{ route('chat') }}">View All <i class="fas fa-chevron-right"></i></a>
        </div>
    </div>
</li>