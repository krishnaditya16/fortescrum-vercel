<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function index()
    {
        return view('pages.user.index');
    }

        /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $data = Team::all();
        $team = Auth::user()->currentTeam;
        return view('pages.user.create', compact('team'));
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
            'password' => 'confirmed|min:8',
            'team_id' => 'required',
        ],[
            'team_id.required' => 'The team field is required',
        ]);

        DB::transaction(function () use ($request) {
            return tap(User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]), function (User $user) use ($request) {
                $team_id = $request->team_id;
                $team = Team::where('id', $team_id)->first();
                $user->teams()->attach($team, array('role' => 'guest'));
                $user->switchTeam($team);
            });
        });

        Alert::success('Success!', 'Data has been succesfully created.');

        return redirect('/user');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $team = Team::where('id', $user->current_team_id)->first();
        return view('pages.user.edit', compact('user', 'team'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|min:3|max:30',
            'email' => 'email',
        ]);
         
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        Alert::success('Success!', 'Data has been succesfully updated.');

        return redirect('/user');
    }

    public function updateTourSettings(Request $request)
    {
        $request->validate([
            'enable_tour' => 'nullable|string',
        ]);

        $user = User::find(Auth::id());
        $user->update([
            'enable_tour' => $request->input('enable_tour') ? '1' : '0',
        ]);


        return redirect()->back()->with('success', 'Tour settings updated successfully.');
    }

}
