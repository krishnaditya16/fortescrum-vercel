<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Task;
use App\Models\User;
use App\Models\Board;
use App\Mail\TaskMail;
use App\Models\Sprint;
use App\Models\Backlog;
use App\Models\Project;
use App\Models\Timesheet;
use App\Models\Notification;
use App\Models\TaskTimeline;
use Illuminate\Http\Request;
use App\Mail\TaskReminderMail;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;

class TaskController extends Controller
{
    public function index()
    {
        return view('pages.task.index');
    }

    public function taskList($id)
    {
        $data = Project::find($id);
        $boards = Board::with('tasks')->where('project_id', $data->id)->get();
        $options = Board::where('project_id', $data->id)->get();

        $backlogs = Backlog::where('project_id', $data->id)->get();
        $sprints = Sprint::where('project_id', $data->id)->get();
        $date_now = Carbon::now();

        $team = Jetstream::newTeamModel()->findOrFail($data->team_id);
        $project = [];
        foreach ($team->users as $user) {
            $project[] = $user->id;
        }

        $owner = DB::table('team_user')
            ->join('users', 'team_user.user_id', 'users.id')
            ->whereIn('user_id', $project)->where('role', 'client-user')
            ->get();

        if($data->team_id != Auth::user()->currentTeam->id){
            abort(403);
        } else {
            return view('pages.project.task.kanban', compact('data', 'boards', 'options', 'owner', 'backlogs', 'sprints', 'date_now'));
        }  
    }

    public function tableView($id) 
    {
        $data = Project::find($id);

        if($data->team_id != Auth::user()->currentTeam->id){
            abort(403);
        } else {
            return view('pages.project.task.table', compact('data'));
        }  
    }

    public function ganttChart($id) 
    {
        $data = Project::find($id);
        $task = Task::where('project_id', $data->id)->get();
        $sprint = Sprint::where('project_id', $data->id)->get();

        if($data->team_id != Auth::user()->currentTeam->id){
            abort(403);
        } else {
            return view('pages.project.task.gantt', compact('data', 'task', 'sprint'));
        }  
    }

    public function taskFinished($id)
    {
        $data = Project::find($id);
        $boards = Board::with('tasks')->where('project_id', $data->id)->get();
        $options = Board::where('project_id', $data->id)->get();

        $backlogs = Backlog::where('project_id', $data->id)->get();
        $sprints = Sprint::where('project_id', $data->id)->get();

        $team = Jetstream::newTeamModel()->findOrFail($data->team_id);
        $project = [];
        foreach ($team->users as $user) {
            $project[] = $user->id;
        }

        $owner = DB::table('team_user')
            ->join('users', 'team_user.user_id', 'users.id')
            ->whereIn('user_id', $project)->where('role', 'client-user')
            ->get();
        
        if($data->team_id != Auth::user()->currentTeam->id){
            abort(403);
        } else {
            return view('pages.project.task.finished', compact('data', 'boards', 'options', 'owner', 'backlogs', 'sprints'));
        }
    }

    public function createTask($id)
    {
        $projects = Project::where('id', $id)->first();
        $boards = Board::where('project_id', $id)->get();
        $sprints = Sprint::where('project_id', $id)->get();
        $backlogs = Backlog::where('project_id', $id)->get();

        $team = Jetstream::newTeamModel()->findOrFail($projects->team_id);

        $data = [];

        foreach ($team->users as $user) {
            $data[] = $user->id;
        }

        $users = DB::table('team_user')
            ->join('users', 'team_user.user_id', 'users.id')
            ->whereIn('user_id', $data)->where('role', 'team-member')
            ->get();

        if(Auth::user()->current_team_id != $projects->team_id){
            abort(403);
        }
        return view('pages.project.task.create-task', compact('projects', 'users', 'boards', 'sprints', 'backlogs'));
    }

    public function storeTask(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'task_date' => 'required',
            'priority' => 'required',
            'board_id' => 'required',
            'sprint_id' => 'required',
            'project_id' => 'required',
            'backlog_id' => 'required',
            'assignee' => 'required'

        ]);

        $data['assignee'] = implode(',', $request->assignee);

        $dates = explode(' - ', $request->task_date);
        $start_date = Carbon::parse($dates[0]);
        $end_date = Carbon::parse($dates[1]);

        Task::create([
            'title' => $request['title'],
            'description' => $request['description'],
            'start_date' => $start_date,
            'end_date' => $end_date,
            'priority' => $request['priority'],
            'board_id' => $request['board_id'],
            'sprint_id' => $request['sprint_id'],
            'project_id' => $request['project_id'],
            'backlog_id' => $request['backlog_id'],
            'assignee' => $data['assignee'],
        ]);

        Notification::create([
            'detail' => $request->title.' has been created!',
            'type' => 3,
            'operation' => 0,
            'user_id' => Auth::user()->id,
            'team_id' => Auth::user()->currentTeam->id,
        ]);

        $users = User::whereIn('id', $request->assignee)->get();
        $project = Project::where('id', $request->project_id)->first();
        $sprint = Sprint::where('id', $request->sprint_id)->first();
        $backlog = Backlog::where('id', $request->backlog_id)->first();

        $details = [
            'title' => 'New Task Has Been Assigned to You',
            'url' => 'http://127.0.0.1:8000/project/'.$request->project_id.'/tasks',
            'project' => $project->title,
            'task' => $request->title,
            'sprint' => $sprint->name,
            'backlog' => $backlog->name,
            'from_mail' => $request->from_mail,
            'mail_sender' => $request->mail_sender,
        ];
        
        foreach($users as $user){
            Mail::to($user->email)->send(new TaskMail($details));
        }

        Alert::success('Success!', 'Task has been succesfully created.');

        $project_id = $request->project_id;
        return redirect()->route('project.task', $project_id);
    }

    public function moveTask(Request $request, $id, $task) 
    {
        $request->validate([
            'board_id' => 'required',
        ]);

        $task = Task::find($task);
        $task->update([
            'board_id' => $request->board_id,
        ]);

        return back();
    }

    public function taskStatus(Request $request, $id, $task) 
    {
        $request->validate([
            'status' => 'required',
        ]);

        $data = Task::find($task);
        $data->update([
            'status' => $request->status,
        ]);

        if($request->status == "1"){
            Notification::create([
                'detail' => $data->title.' has been marked as done!',
                'type' => 3,
                'operation' => 2,
                'user_id' => Auth::user()->id,
                'team_id' => Auth::user()->currentTeam->id,
            ]);
            Alert::success('Success!', 'Task has been marked as done.');
            return back();
        } else {
            Notification::create([
                'detail' => $data->title.' has been moved back to in progress kanban!',
                'type' => 3,
                'operation' => 3,
                'user_id' => Auth::user()->id,
                'team_id' => Auth::user()->currentTeam->id,
            ]);
            Alert::success('Success!', 'Task has been moved back to in progress kanban.');
            return back();
        }
    }

    public function editTask($id, Task $task)
    {
        $projects = Project::where('id', $id)->first();
        $boards = Board::where('project_id', $id)->get();
        $sprints = Sprint::where('project_id', $id)->get();
        $backlogs = Backlog::where('project_id', $id)->get();

        $team = Jetstream::newTeamModel()->findOrFail($projects->team_id);

        $data = [];

        foreach ($team->users as $user) {
            $data[] = $user->id;
        }

        $start_date = $task->start_date;
        $end_date = $task->end_date;
        $arr = array($start_date, $end_date);
        $dates = implode(' - ', $arr);

        $arr_user = $task->assignee;
        $assignee = explode(",",$arr_user);
        

        $users = DB::table('team_user')
            ->join('users', 'team_user.user_id', 'users.id')
            ->whereIn('user_id', $data)->where('role', 'team-member')
            ->get();

        $current_team = Auth::user()->currentTeam;

        if (empty($projects) || $current_team->id != $projects->team_id) {
            abort(403);
        } else if ($task->project_id != $id){
            abort(404);
        } else {
            return view('pages.project.task.edit-task', compact('task', 'projects', 'users', 'boards', 'sprints', 'backlogs', 'dates', 'assignee'));
        }  
    }

    public function updateTask(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'task_date' => 'required',
            'priority' => 'required',
            'board_id' => 'required',
            'sprint_id' => 'required',
            'project_id' => 'required',
            'backlog_id' => 'required',
            'task_id' => 'required',
            'assignee' => 'required'

        ]);

        $data['assignee'] = implode(',', $request->assignee);

        $dates = explode(' - ', $request->task_date);
        $start_date = Carbon::parse($dates[0]);
        $end_date = Carbon::parse($dates[1]);
        
        $id = $request->task_id;
        $task = Task::where('id', $id);
        $task->update([
            'title' => $request['title'],
            'description' => $request['description'],
            'start_date' => $start_date,
            'end_date' => $end_date,
            'priority' => $request['priority'],
            'board_id' => $request['board_id'],
            'sprint_id' => $request['sprint_id'],
            'project_id' => $request['project_id'],
            'backlog_id' => $request['backlog_id'],
            'assignee' => $data['assignee'],
        ]);

        Notification::create([
            'detail' => $request->title.' has been updated!',
            'type' => 3,
            'operation' => 1,
            'user_id' => Auth::user()->id,
            'team_id' => Auth::user()->currentTeam->id,
        ]);

        Alert::success('Success!', 'Task has been succesfully updated.');

        $project_id = $request->project_id;
        return redirect()->route('project.task', $project_id);
    }

    public function editTaskProgress($id, Task $task)
    {
        $projects = Project::where('id', $id)->first();
        $timelines = TaskTimeline::where('task_id', $task->id)->get()->sortByDesc("created_at");;

        $team = Jetstream::newTeamModel()->findOrFail($projects->team_id);

        $data = [];

        foreach ($team->users as $user) {
            $data[] = $user->id;
        }

        $users = DB::table('team_user')
            ->join('users', 'team_user.user_id', 'users.id')
            ->whereIn('user_id', $data)->where('role', 'team-member')
            ->get();

        $team = Jetstream::newTeamModel()->findOrFail($projects->team_id);
        $current_team = Auth::user()->currentTeam;

        $loggedInUserId = Auth::id();
        $assignees = explode(',', $task->assignee);

        if (empty($projects) || $current_team->id != $projects->team_id) {
            abort(403);
        } else if ($task->project_id != $id){
            abort(404);
        } else if(in_array($loggedInUserId, $assignees) || Auth::user()->hasTeamRole($team, 'project-manager')){
            return view('pages.project.task.edit-task-progress', compact('task', 'projects', 'users', 'timelines'));
        } else {
            abort(403);
        }  
    }

    public function updateTaskProgress($project_id, $task_id, Request $request)
    {
        $request->validate([
            'task_progress' => 'required',
            'notes' => 'required',
        ]);
        
        $task = Task::where('id', $task_id);
        $task->update([
            'progress' => $request->task_progress,
        ]);

        TaskTimeline::create([
            'current_progress' => $request->task_progress,
            'notes' => $request->notes,
            'user_id' => Auth::user()->id,
            'project_id' => $project_id,
            'task_id' => $task_id,
        ]);

        Alert::success('Success!', 'Task progress has been succesfully updated.');

        return redirect()->route('project.task', $project_id);
    }

    public function destroyTask($id, $task)
    {
        $data = Task::find($task);
        Task::where('id', $data->id)->delete();

        Notification::create([
            'detail' => $data->title.' has been deleted!',
            'type' => 3,
            'operation' => 4,
            'user_id' => Auth::user()->id,
            'team_id' => Auth::user()->currentTeam->id,
        ]);

        Alert::success('Success!', 'Task has been succesfully deleted.');

        return back();
    }

    public function taskReminder(Request $request)
    {
        $task = Task::where('id', $request->task_id)->first();
        $project = Project::where('id', $task->project_id)->first();
        $sprint = Sprint::where('id', $task->sprint_id)->first();
        $backlog = Backlog::where('id', $task->backlog_id)->first();
        $assignee = explode(',', $task->assignee);
        $users = User::whereIn('id', $assignee)->get();

        $from_mail = Auth::user()->email;
        $mail_sender = Auth::user()->name;

        $details = [
            'title' => 'Please Finish This Task Before The Due Date',
            'url' => 'http://127.0.0.1:8000/project/'.$project->id.'/tasks',
            'project' => $project->title,
            'task' => $task->title,
            'due_date' => date('D, d M Y', strtotime($task->end_date)),
            'sprint' => $sprint->name,
            'backlog' => $backlog->name,
            'from_mail' => $from_mail,
            'mail_sender' => $mail_sender,
        ];
        
        foreach($users as $user){
            Mail::to($user->email)->send(new TaskReminderMail($details));
        }

        Alert::success('Success!', 'Email reminder has been succesfully sent.');
        return back();
    }
}
