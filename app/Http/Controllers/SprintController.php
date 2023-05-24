<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Project;
use App\Models\Sprint;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Jetstream\Jetstream;
use RealRashid\SweetAlert\Facades\Alert;

class SprintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.sprint.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = Project::where('team_id', Auth::user()->currentTeam->id)->get();
        return view('pages.sprint.create', compact('projects'));
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
            'name' => ['required', 'numeric', 'min:1',Rule::unique('sprints')->where(function ($query) use ($request) {
                return $query->where('project_id', $request->project_id);
            })],
            'project_id' => 'required',
            'sprint_date' => 'required',
            'focus_factor' => 'required|min:1|max:100',
        ],[
            'name.unique' => 'Sprint iteration already exist for selected project.',
            'name.required' => 'The sprint iteration field is required.',
            'project_id.required' => 'The project field is required.',
        ]);

        $dates = explode(' - ', $request->sprint_date);
        $start_date = Carbon::parse($dates[0]);
        $end_date = Carbon::parse($dates[1]);

        $date_diff = ($start_date->diffInDays($end_date))+1;

        $project_id = $request->project_id;
        $projects = Project::where('id', $project_id)->first();
        $team = Jetstream::newTeamModel()->findOrFail($projects->team_id);

        $data = [];

        foreach ($team->users as $user) {
            $data[] = $user->id;
        }

        $users = DB::table('team_user')
            ->join('users', 'team_user.user_id', 'users.id')
            ->whereIn('user_id', $data)->where('role', 'team-member')
            ->get();
        
        $total_member = count($users);
        $man_days = $total_member*$date_diff;

        Sprint::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'start_date' => $start_date,
            'end_date' => $end_date,
            'total_sp' => ($man_days*$request->focus_factor)/100,
            'focus_factor' => $request['focus_factor'],
            'project_id' => $request['project_id'],
        ]);

        Notification::create([
            'detail' => $request->name.' - sprint iteration has been created!',
            'type' => 1,
            'operation' => 0,
            'user_id' => Auth::user()->id,
            'team_id' => Auth::user()->currentTeam->id,
        ]);

        Alert::success('Success!', 'Data has been succesfully created.');

        return redirect('/sprint');
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
    public function edit(Sprint $sprint)
    {
        $data = Sprint::join('projects', 'sprints.project_id', 'projects.id')->select('team_id')->first();
        $current_team = Auth::user()->currentTeam;
        $projects = Project::where('team_id', Auth::user()->currentTeam->id)->get();
        $start_date = $sprint->start_date;
        $end_date = $sprint->end_date;
        $arr = array($start_date, $end_date);
        $dates = implode(' - ', $arr);
        
        if (empty($data) || $current_team->id != $data->team_id) {
            abort(403);
        }
        else {
            return view('pages.sprint.edit', compact('sprint','projects','dates',));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sprint $sprint)
    {
        $request->validate([
            'name' => ['required', 'numeric', 'min:1', Rule::unique('sprints')->ignore($sprint->id)->where(function ($query) use ($request) {
                return $query->where('project_id', $request->project_id);
            })],
            'project_id' => 'required',
            'sprint_date' => 'required',
            'focus_factor' => 'required|min:1|max:100',
        ],[
            'name.unique' => 'Sprint iteration already exist for selected project.',
            'name.required' => 'The sprint iteration field is required.',
            'project_id.required' => 'The project field is required.',
        ]);

        $dates = explode(' - ', $request->sprint_date);
        $start_date = Carbon::parse($dates[0]);
        $end_date = Carbon::parse($dates[1]);

        $date_diff = ($start_date->diffInDays($end_date))+1;

        $project_id = $request->project_id;
        $projects = Project::where('id', $project_id)->first();
        $team = Jetstream::newTeamModel()->findOrFail($projects->team_id);

        $data = [];

        foreach ($team->users as $user) {
            $data[] = $user->id;
        }

        $users = DB::table('team_user')
            ->join('users', 'team_user.user_id', 'users.id')
            ->whereIn('user_id', $data)->where('role', 'team-member')
            ->get();
        
        $total_member = count($users);
        $man_days = $total_member*$date_diff;
        $desc = $request->description;

        if($desc == "<p><br></p>"){
            $sprint->update([
                'description' => "",
                'start_date' => $start_date,
                'end_date' => $end_date,
                'total_sp' => ($man_days*$request->focus_factor)/100,
                'focus_factor' => $request['focus_factor'],
                'project_id' => $request['project_id']
            ]);
        } else {
            $sprint->update([
                'description' => $request['description'],
                'start_date' => $start_date,
                'end_date' => $end_date,
                'total_sp' => ($man_days*$request->focus_factor)/100,
                'focus_factor' => $request['focus_factor'],
                'project_id' => $request['project_id'],
            ]);
        }

        Alert::success('Success!', 'Sprint has been succesfully updated.');

        return redirect('/sprint');
    }

    public function createProjectSprint($id) 
    {
        $projects = Project::where('id', $id)->first();

        return view('pages.project.sprint.create', compact('projects'));
    }

    public function storeProjectSprint(Request $request) 
    {
        $request->validate([
            'name' => ['required', 'numeric', 'min:1',Rule::unique('sprints')->where(function ($query) use ($request) {
                return $query->where('project_id', $request->project_id);
            })],
            'project_id' => 'required',
            'sprint_date' => 'required',
            'focus_factor' => 'required|min:1|max:100',
        ],[
            'name.unique' => 'Sprint iteration already exist for selected project.',
            'name.required' => 'The sprint iteration field is required.',
            'project_id.required' => 'The project field is required.',
        ]);

        $dates = explode(' - ', $request->sprint_date);
        $start_date = Carbon::parse($dates[0]);
        $end_date = Carbon::parse($dates[1]);

        $date_diff = ($start_date->diffInDays($end_date))+1;

        $project_id = $request->project_id;
        $projects = Project::where('id', $project_id)->first();
        $team = Jetstream::newTeamModel()->findOrFail($projects->team_id);

        $data = [];

        foreach ($team->users as $user) {
            $data[] = $user->id;
        }

        $users = DB::table('team_user')
            ->join('users', 'team_user.user_id', 'users.id')
            ->whereIn('user_id', $data)->where('role', 'team-member')
            ->get();
        
        $total_member = count($users);
        $man_days = $total_member*$date_diff;

        Sprint::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'start_date' => $start_date,
            'end_date' => $end_date,
            'total_sp' => ($man_days*$request->focus_factor)/100,
            'focus_factor' => $request['focus_factor'],
            'project_id' => $request['project_id'],
        ]);

        Notification::create([
            'detail' => $request->name.' - sprint iteration has been created!',
            'type' => 1,
            'operation' => 0,
            'user_id' => Auth::user()->id,
            'team_id' => Auth::user()->currentTeam->id,
        ]);

        Alert::success('Success!', 'Sprint has been succesfully created.');

        return redirect()->route('project.show', $project_id);
    }

    public function editProjectSprint($id, Sprint $sprint) 
    {
        $projects = Project::where('id', $id)->first();
        $start_date = $sprint->start_date;
        $end_date = $sprint->end_date;
        $arr = array($start_date, $end_date);
        $dates = implode(' - ', $arr);

        return view('pages.project.sprint.edit', compact('sprint','projects','dates'));
    }

    public function updateProjectSprint(Request $request) 
    {
        $request->validate([
            'project_id' => 'required',
            'sprint_date' => 'required',
            'focus_factor' => 'required|min:1|max:100',
        ],[
            'name.required' => 'The sprint iteration field is required.',
            'project_id.required' => 'The project field is required.',
        ]);

        $dates = explode(' - ', $request->sprint_date);
        $start_date = Carbon::parse($dates[0]);
        $end_date = Carbon::parse($dates[1]);

        $date_diff = ($start_date->diffInDays($end_date))+1;

        $project_id = $request->project_id;
        $projects = Project::where('id', $project_id)->first();
        $team = Jetstream::newTeamModel()->findOrFail($projects->team_id);

        $data = [];

        foreach ($team->users as $user) {
            $data[] = $user->id;
        }

        $users = DB::table('team_user')
            ->join('users', 'team_user.user_id', 'users.id')
            ->whereIn('user_id', $data)->where('role', 'team-member')
            ->get();
        
        $total_member = count($users);
        $man_days = $total_member*$date_diff;

        $id = $request->sprint_id;
        $sprint = Sprint::where('id', $id)->first();
        $desc = $request->description;

        if($request->name == $sprint->name){
            $sprint->update([
                'name' => $sprint->name,
                'description' => $request['description'],
                'start_date' => $start_date,
                'end_date' => $end_date,
                'total_sp' => ($man_days*$request->focus_factor)/100,
                'focus_factor' => $request['focus_factor'],
                'project_id' => $request['project_id'],
            ]);
        } else {
            if($desc == "<p><br></p>"){
                $sprint->update([
                    'name' => $request['name'],
                    'description' => "",
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'total_sp' => ($man_days*$request->focus_factor)/100,
                    'focus_factor' => $request['focus_factor'],
                    'project_id' => $request['project_id']
                ]);
            } else {
                $sprint->update([
                    'name' => $request['name'],
                    'description' => $request['description'],
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'total_sp' => ($man_days*$request->focus_factor)/100,
                    'focus_factor' => $request['focus_factor'],
                    'project_id' => $request['project_id'],
                ]);
            }
        }
        

        Notification::create([
            'detail' => 'Sprint iteration - '.$request->name.', has been updated!',
            'type' => 1,
            'operation' => 1,
            'user_id' => Auth::user()->id,
            'team_id' => Auth::user()->currentTeam->id,
        ]);

        Alert::success('Success!', 'Sprint has been succesfully updated.');

        return redirect()->route('project.show', $project_id);
    }

    public function sprintStatus(Request $request)
    {
        $request->validate([
            'status' => 'required',
        ]);

        $id = $request->sprint_id;

        $sprint = Sprint::find($id);
        $sprint->update([
            'status' => $request->status,
        ]);

        if($request->status == "1"){
            Alert::success('Success!', 'Sprint has been closed.');
            return back();
        } else {
            Alert::success('Success!', 'Sprint has been opened again.');
            return back();
        }
    }
}
