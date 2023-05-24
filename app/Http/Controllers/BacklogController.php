<?php

namespace App\Http\Controllers;

use App\Models\Backlog;
use App\Models\Notification;
use App\Models\Project;
use App\Models\Sprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class BacklogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.backlog.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $current_team = Auth::user()->currentTeam->id;
        $projects = Project::where('team_id', $current_team)->get();
        $sprints = Sprint::join('projects', 'sprints.project_id', 'projects.id')->where('projects.team_id', $current_team)->get();
        return view('pages.backlog.create', compact('projects', 'sprints'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sprint_data = Sprint::where('id', $request->sprint_id)->select('total_sp', 'name')->first();
        $sp = Backlog::where('sprint_id', $request->sprint_id)->select('story_point')->get();
        $total_sp = $sprint_data['total_sp'];

        foreach ($sp as $data) {
            $total_sp = $total_sp - $data->story_point;
        }

        $request->validate([
            'name' => 'required',
            'story_point' => 'required|numeric|min:1|max:' . $total_sp,
            'sprint_id' => 'required',
            'project_id' => 'required',
        ]);

        Backlog::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'story_point' => $request['story_point'],
            'sprint_name' => $sprint_data['name'],
            'sprint_id' => $request['sprint_id'],
            'project_id' => $request['project_id'],
        ]);

        Notification::create([
            'detail' => $request['name'].' backlog has been created!',
            'type' => 2,
            'operation' => 0,
            'team_id' => Auth::user()->currentTeam->id,
            'user_id' => Auth::user()->id,
        ]);

        Alert::success('Success!', 'Data has been succesfully created.');

        return redirect('/backlog');
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
    public function edit(Backlog $backlog)
    {
        $data = Backlog::join('projects', 'backlogs.project_id', 'projects.id')->select('team_id')->first();
        $current_team = Auth::user()->currentTeam;
        $projects = Project::where('team_id', Auth::user()->currentTeam->id)->get();
        $sprints = Sprint::all();

        if (empty($data) || $current_team->id != $data->team_id) {
            abort(403);
        } else {
            return view('pages.backlog.edit', compact('backlog', 'projects', 'sprints'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Backlog $backlog)
    {
        $sprint_data = Sprint::where('id', $request->sprint_id)->select('total_sp', 'name')->first();
        $sp = Backlog::where('sprint_id', $request->sprint_id)->select('story_point')->get();
        $total_sp = $sprint_data['total_sp'];

        foreach ($sp as $data) {
            $total_sp = $total_sp - $data->story_point;
        }

        $tsp = $total_sp + $backlog->story_point;

        $request->validate([
            'name' => 'required',
            'story_point' => 'required|numeric|min:1|max:' . $tsp,
            'sprint_id' => 'required',
            'project_id' => 'required',
        ]);

        $desc = $request->description;

        if ($desc == "<p><br></p>") {
            $backlog->update([
                'name' => $request['name'],
                'description' => "",
                'story_point' => $request['story_point'],
                'sprint_name' => $sprint_data['name'],
                'sprint_id' => $request['sprint_id'],
                'project_id' => $request['project_id'],
            ]);
        } else {
            $backlog->update([
                'name' => $request['name'],
                'description' => $request['description'],
                'story_point' => $request['story_point'],
                'sprint_name' => $sprint_data['name'],
                'sprint_id' => $request['sprint_id'],
                'project_id' => $request['project_id'],
            ]);
        }

        Notification::create([
            'detail' => $request['name'].' backlog has been updated!',
            'type' => 2,
            'operation' => 1,
            'team_id' => Auth::user()->currentTeam->id,
            'user_id' => Auth::user()->id,
        ]);

        Alert::success('Success!', 'Data has been succesfully updated.');

        return redirect('/backlog');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function createProjectBacklog($id)
    {
        $projects = Project::where('id', $id)->first();
        $sprints = Sprint::where('project_id', $projects->id)->get();

        return view('pages.project.backlog.create', compact('projects', 'sprints'));
    }

    public function storeProjectBacklog(Request $request)
    {
        if (!empty($request->sprint_id)) {
            $sprint_data = Sprint::where('id', $request->sprint_id)->select('total_sp', 'name')->first();
            $sp = Backlog::where('sprint_id', $request->sprint_id)->select('story_point')->get();
            $total_sp = $sprint_data['total_sp'];

            foreach ($sp as $data) {
                $total_sp = $total_sp - $data->story_point;
            }

            $request->validate([
                'name' => 'required',
                'story_point' => 'required|numeric|min:1|max:' . $total_sp,
                'sprint_id' => 'required',
                'project_id' => 'required',
            ]);

            $project_id = $request->project_id;

            Backlog::create([
                'name' => $request['name'],
                'description' => $request['description'],
                'story_point' => $request['story_point'],
                'sprint_name' => $sprint_data['name'],
                'sprint_id' => $request['sprint_id'],
                'project_id' => $request['project_id'],
            ]);

            Notification::create([
                'detail' => $request['name'].' backlog has been created!',
                'type' => 2,
                'operation' => 0,
                'team_id' => Auth::user()->currentTeam->id,
                'user_id' => Auth::user()->id,
            ]);

            Alert::success('Success!', 'Backlog has been succesfully created.');

            return redirect()->route('project.show', $project_id);
        } else {
            $request->validate([
                'name' => 'required',
                'story_point' => 'required|numeric|min:1',
                'sprint_id' => 'required',
                'project_id' => 'required',
            ]);
        }
    }

    public function editProjectBacklog($id, Backlog $backlog)
    {
        $projects = Project::where('id', $id)->first();
        $sprints = Sprint::where('project_id', $projects->id)->get();

        return view('pages.project.backlog.edit', compact('backlog', 'projects', 'sprints'));
    }

    public function updateProjectBacklog(Request $request)
    {
        if (!empty($request->sprint_id)) {
            $sprint_data = Sprint::where('id', $request->sprint_id)->select('total_sp', 'name')->first();
            $sp = Backlog::where('sprint_id', $request->sprint_id)->select('story_point')->get();
            $total_sp = $sprint_data['total_sp'];

            foreach ($sp as $data) {
                $total_sp = $total_sp - $data->story_point;
            }

            $id = $request->backlog_id;
            $backlog = Backlog::where('id', $id)->first();

            $tsp = $total_sp + $backlog->story_point;

            $request->validate([
                'name' => 'required',
                'story_point' => 'required|numeric|min:1|max:' . $tsp,
                'sprint_id' => 'required',
                'project_id' => 'required',
            ]);

            $desc = $request->description;

            if ($desc == "<p><br></p>") {
                $backlog->update([
                    'name' => $request['name'],
                    'description' => "",
                    'story_point' => $request['story_point'],
                    'sprint_name' => $sprint_data['name'],
                    'sprint_id' => $request['sprint_id'],
                    'project_id' => $request['project_id'],
                ]);
            } else {
                $backlog->update([
                    'name' => $request['name'],
                    'description' => $request['description'],
                    'story_point' => $request['story_point'],
                    'sprint_name' => $sprint_data['name'],
                    'sprint_id' => $request['sprint_id'],
                    'project_id' => $request['project_id'],
                ]);
            }

            Notification::create([
                'detail' => $request['name'].' backlog has been updated!',
                'type' => 2,
                'operation' => 1,
                'team_id' => Auth::user()->currentTeam->id,
                'user_id' => Auth::user()->id,
            ]);

            Alert::success('Success!', 'Backlog has been succesfully updated.');

            $project_id = $request->project_id;
            return redirect()->route('project.show', $project_id);
        } else {
            $request->validate([
                'name' => 'required',
                'story_point' => 'required|numeric|min:1',
                'sprint_id' => 'required',
                'project_id' => 'required',
            ]);
        }
    }
}
