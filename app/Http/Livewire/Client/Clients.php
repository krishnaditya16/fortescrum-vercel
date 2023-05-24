<?php

namespace App\Http\Livewire\Client;

use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Clients extends Component
{
    public function render()
    {
        $team = Auth::user()->currentTeam;
        $data = [];
        foreach ($team->users as $user) {
            if($user->hasTeamRole($team, 'client-user')){
                $data[] = $user->id;
            }
        }
        $client = Client::whereIn('user_id', $data)->first();
        return view('livewire.client.clients', compact('client'));
    }
}
