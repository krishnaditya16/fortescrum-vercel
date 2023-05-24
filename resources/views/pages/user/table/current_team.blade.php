@php
use App\Models\User;
$current_team = User::join('teams', 'teams.id', '=', 'users.current_team_id')
->select('teams.*', 'users.current_team_id')
->get();

foreach($current_team as $data) {
    if($value == $data->id){
        $team_name = $data->name;
    }
}
@endphp

<div class="badge badge-primary">{{$team_name}}</div>

