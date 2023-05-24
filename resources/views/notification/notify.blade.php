@php
$team = Auth::user()->currentTeam->id;
$user = Auth::user()->id;
$notifs = App\Models\Notification::whereNull('read_at')->where('team_id', $team)->get();
$count = count($notifs);
@endphp
<li class="dropdown dropdown-list-toggle pr-3">
    <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg @if($count != 0) beep @endif">
        <i class="far fa-bell"></i>
        @if($count != 0)
            <span class="badge badge-notification">{{$count}}</span>
        @endif
    </a>
    <div class="dropdown-menu dropdown-list dropdown-menu-right">
        <div class="dropdown-header">Notifications
            @if($count != 0)
            <div class="float-right">
                <form action="{{ route('notif.read.all') }}" method="post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="notif_id[]" value="{!! $notifs->pluck('id') !!}">
                    <a href="javascript:void(0)" class="notif-read">Mark All As Read</a>
                </form>
            </div>
            @endif
        </div>
        <div class="dropdown-list-content dropdown-list-icons">
            @forelse($notifs as $notif)
            <form action="{{ route('notif.read') }}" method="post">
                @csrf
                @method('PUT')
                <input type="hidden" name="notif_id" value="{{ $notif->id }}">
                <a href="javascript:void(0)" class="dropdown-item dropdown-item-unread notif-read" data-toggle="tooltip" title="Click to dismiss notification!">
                    @if($notif->type == "0")
                        <div class="dropdown-item-icon 
                            @if($notif->operation == "0") 
                                bg-info 
                            @elseif($notif->operation == "1")
                                bg-warning 
                            @elseif($notif->operation == "4")
                                bg-danger 
                            @endif text-white">
                            <i class="fas fa-folder"></i>
                        </div>
                    @elseif($notif->type == "1")
                        <div class="dropdown-item-icon 
                            @if($notif->operation == "0") 
                                bg-info 
                            @elseif($notif->operation == "1")
                                bg-warning 
                            @elseif($notif->operation == "4")
                                bg-danger 
                            @endif text-white">
                            <i class="fas fa-folder-open"></i>
                        </div>
                    @elseif($notif->type == "2")
                        <div class="dropdown-item-icon 
                            @if($notif->operation == "0") 
                                bg-info 
                            @elseif($notif->operation == "1")
                                bg-warning 
                            @elseif($notif->operation == "4")
                                bg-danger 
                            @endif text-white">
                            <i class="fas fa-flag"></i>
                        </div>
                    @elseif($notif->type == "3")
                        <div class="dropdown-item-icon
                            @if($notif->operation == "0") 
                                bg-info 
                            @elseif($notif->operation == "1" || $notif->operation == "3")
                                bg-warning  
                            @elseif($notif->operation == "2") 
                                bg-success 
                            @elseif($notif->operation == "4") 
                                bg-danger
                            @endif text-white">
                            <i class="fas fa-code"></i>
                        </div>
                    @endif
                    <div class="dropdown-item-desc">
                        {{ $notif->detail }}
                        <div class="time text-primary">{{ date('D, d M Y H:i A', strtotime($notif->updated_at)) }}</div>
                    </div>
                </a>
            </form>
            @empty
            <a href="#" class="dropdown-item dropdown-item-unread">
                <div class="dropdown-item-icon bg-secondary text-white">
                    <i class="fas fa-check"></i>
                </div>
                <div class="dropdown-item-desc">
                    You have no notification!
                    <div class="time text-primary">Now</div>
                </div>
            </a>
            @endforelse
        </div>
        <div class="dropdown-footer text-center">
            <a href="{{ route('notif.show') }}">View All <i class="fas fa-chevron-right"></i></a>
        </div>
    </div>
</li>
