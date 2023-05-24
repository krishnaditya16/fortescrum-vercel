<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.client.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $data = User::where('current_team_id', Auth::user()->currentTeam->id)->get();
        $team = Auth::user()->currentTeam;
        $data = $team->users;

        $user_id = [];
        foreach ($team->users as $user) {
            if($user->hasTeamRole($team, 'client-user')){
                $user_id[] = $user->id;
            }
        }
        $client = Client::whereIn('user_id', $user_id)->first();

        if(empty($client)){
            return view('pages.client.create', compact('data'));
        } else {
            Alert::warning('Warning!', 'A client is already registered for this team!');
            return back();
        };
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:30',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'address' => 'required',
            'user_id' => ['required',Rule::unique('clients')->where(function ($query) use ($request) {
                return $query->where('user_id', $request->user_id);
            })],
        ],[
            'user_id.unique' => 'Selected user already exist as owner of other client\'s account.',
            'user_id.required' => 'The client\'s user field is required.',
        ]);

        $client = Client::create($request->all());

        DB::table('users')->where('id', $request['user_id'])->update(['client_id' => $client->id]);

        Alert::success('Success!', 'Data has been succesfully created.');

        return redirect('/client');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        $data = User::all();
        return view('pages.client.edit', compact('client', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'name' => 'required|min:3|max:30',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'address' => 'required'
        ]);

        $client->update($request->all());

        Alert::success('Success!', 'Data has been succesfully updated.');

        return redirect('/client');
    }
    
}
