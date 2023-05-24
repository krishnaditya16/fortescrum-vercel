<?php

namespace App\Http\Controllers;

use App\Models\Backlog;
use App\Models\Board;
use App\Models\Project;
use App\Models\Sprint;
use App\Models\Task;
use App\Models\Timesheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Jetstream\Jetstream;
use RealRashid\SweetAlert\Facades\Alert;

class TimesheetController extends Controller
{
    public function createTimesheet($project_id, $task_id)
    {
        $projects = Project::where('id', $project_id)->first();
        $boards = Board::where('project_id', $project_id)->get();
        $sprints = Sprint::where('project_id', $project_id)->get();
        $backlogs = Backlog::where('project_id', $project_id)->get();
        $tasks = Task::where('id', $task_id)->where('project_id', $project_id)->first();

        $team = Jetstream::newTeamModel()->findOrFail($projects->team_id);

        $data = [];

        foreach ($team->users as $user) {
            $data[] = $user->id;
        }

        $users = DB::table('team_user')
            ->join('users', 'team_user.user_id', 'users.id')
            ->whereIn('user_id', $data)->where('role', 'team-member')
            ->get();

        $current_team = Auth::user()->currentTeam;

        if (empty($projects) || $current_team->id != $projects->team_id) {
            abort(403);
        } else if(empty($tasks)){
            abort(404);
        } else {
            return view('pages.project.task.create-timesheet', compact('projects', 'tasks', 'users', 'boards', 'sprints', 'backlogs'));
        }
    }

    public function storeTimesheet(Request $request) 
    {
        $request->validate([
            'work_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'project_id' => 'required',
            'task_id' => 'required',
        ]);

        $start_time = date("H:i:s", strtotime($request->start_time));
        $end_time = date("H:i:s", strtotime($request->end_time));

        Timesheet::create([
            'work_date' => $request->work_date,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'project_id' => $request->project_id,
            'task_id' => $request->task_id,
            'user_id' => $request->user_id,
            'team_id' => $request->team_id,
        ]);

        Alert::success('Success!', 'Your timesheet for this task has been succesfully recorded.');

        $project_id = $request->project_id;
        return redirect()->route('project.task', $project_id);
    }
}
