<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Task;
use App\Models\Team;
use App\Models\Client;
use App\Models\Expense;
use App\Models\Project;
use App\Mail\ProjectMail;
use App\Models\Timesheet;
use App\Models\Notification;
use Illuminate\Http\Request;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.project.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teams = Auth::user()->currentTeam;

        $data = [];
        foreach ($teams->users as $user) {
            $data[] = $user->id;
        }

        $clients = DB::table('team_user')
            ->join('users', 'team_user.user_id', 'users.id')
            ->join('clients', 'users.client_id', 'clients.id')
            ->whereIn('team_user.user_id', $data)->where('role', 'client-user')
            ->select('clients.id', 'clients.name')
            ->first();

        return view('pages.project.create', compact('teams', 'clients'));
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
            'title' => 'required|min:3|max:30',
            'description' => 'required',
            'project_date' => 'required',
            'budget' => 'required',
            'category' => 'required',
            'platform' => 'required',
            'proposal' => 'required|mimes:pdf,docx|max:2048',
            'team_id' =>  'required',
            'client_id' => 'required'
        ],[
            'client_id.required' => 'The client field is required! Please register a client first for this team.'
        ]);

        $dates = explode(' - ', $request->project_date);
        $start_date = Carbon::parse($dates[0]);
        $end_date = Carbon::parse($dates[1]);

        $file = $request->file('proposal');

        if ($proposalFile = $request->file('proposal')) {
            $destinationPath = 'uploads/proposal';
            $proposalName1 = $proposalFile->getClientOriginalName();
            $proposalName2 = explode('.', $proposalName1)[0]; // Filename 'filename'
            $proposalName = $proposalName2 . "_" . date('YmdHis') . "." . $proposalFile->getClientOriginalExtension();
            $proposalFile->move($destinationPath, $proposalName);
            $file = "$proposalName";
        } else {
            unset($file);
        }

        $numbers = explode(',', $request->budget);
        $budget = (int)join('', $numbers);

        $project = Project::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'title' => $request['title'],
            'description' => $request['description'],
            'budget' => $budget,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'category' => $request['category'],
            'platform' => $request['platform'],
            'proposal' => $proposalName,
            'team_id' => $request['team_id'],
            'client_id' => $request['client_id'],
        ]);

        $details = [
            'title' => 'New Project Has Been Assigned to You',
            'url' => 'http://127.0.0.1:8000/project/'.$project->id,
            'project' => $request->title,
            'client' => $request->title,
            'start_date' => $start_date,
            'due_date' => $end_date,
            'budget' => $request->budget,
            'category' => $request->category,
            'platform' => $request->platform,
            'from_mail' => $request->from_mail,
            'mail_sender' => $request->mail_sender,
        ];

        $users = Auth::user()->currentTeam->allUsers();
        
        foreach($users as $user){
            Mail::to($user->email)->send(new ProjectMail($details));
        }

        Notification::create([
            'detail' => $request->title . ' has been created!',
            'type' => 0,
            'operation' => 0,
            'user_id' => Auth::user()->id,
            'team_id' => Auth::user()->currentTeam->id,
        ]);

        Alert::success('Success!', 'Data has been succesfully updated.');
        return redirect('/project');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        // $team = Team::where('id', $project->team_id)->get();
        // $data = $team->users;
        $team = Jetstream::newTeamModel()->findOrFail($project->team_id);

        $users = $team->allUsers();
        $po = [];
        $pm = [];
        $tm = [];
        $data = [];

        foreach ($team->users as $user) {
            $data[] = $user->id;
        }

        foreach ($users as $user) {
            if ($user->hasTeamRole($team, 'client-user') && !$user->ownsTeam($team)) {
                $po[] = $user;
            }
        }

        foreach ($users as $user) {
            if ($user->hasTeamRole($team, 'project-manager')) {
                $pm[] = $user;
            }
        }

        foreach ($users as $user) {
            if ($user->hasTeamRole($team, 'team-member') && !$user->ownsTeam($team)) {
                $tm[] = $user;
            }
        }

        $team_owner = DB::table('teams')
            ->join('users', 'teams.user_id', 'users.id')->first();

        $client = Client::where('id', $project->client_id)->first();

        $data = Project::find($project->id);
        $current_team = Auth::user()->currentTeam;

        $date_now = Carbon::now();
        $due_date = date('Y-m-d', strtotime($project->end_date));
        $date_diff = ($date_now->diffInDays($due_date)) + 1;
        $task = Task::where('project_id', $project->id)->get();
        $team = Team::where('id', $project->team_id)->first();

        $times = Timesheet::where('project_id', $project->id)->get();
        $e = new \DateTime('00:00');
        $f = clone $e;
        foreach ($times as $time) {
            $startTime = Carbon::parse($time->start_time);
            $endTime = Carbon::parse($time->end_time);
            $interval = $endTime->diff($startTime);
            $e->add($interval);
        }
        $time_spent = $f->diff($e)->format("%H hrs : %I mins");

        $spending = Expense::where('project_id', $project->id)->where('expenses_status', 1)->sum('ammount')/100;
        $expenses = Expense::where("project_id", $project->id)->get();

        if (empty($project) || $current_team->id != $project->team_id) {
            abort(403);
        } else {
            return view('pages.project.show', compact(
                'project',
                'client',
                'po',
                'pm',
                'tm',
                'team_owner',
                'date_now',
                'due_date',
                'date_diff',
                'task',
                'team',
                'time_spent',
                'spending',
                'expenses'
            ));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $data = Project::find($project->id);
        $teams = Auth::user()->currentTeam;

        $arr = [];
        foreach ($teams->users as $user) {
            $arr[] = $user->id;
        }

        $clients = DB::table('team_user')
            ->join('users', 'team_user.user_id', 'users.id')
            ->join('clients', 'users.client_id', 'clients.id')
            ->whereIn('team_user.user_id', $arr)->where('role', 'client-user')
            ->select('clients.id', 'clients.name')
            ->first();

        $start_date = $project->start_date;
        $end_date = $project->end_date;
        $arr = array($start_date, $end_date);
        $dates = implode(' - ', $arr);

        if ($teams->id != $data->team_id) {
            abort(403);
        } else {
            if (Auth::user()->hasTeamPermission($teams, 'edit:project')) {
                return view('pages.project.edit', compact('project', 'teams', 'clients', 'dates'));
            } else {
                abort(403);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required|min:3|max:30',
            'description' => 'required',
            'project_date' => 'required',
            'category' => 'required',
            'platform' => 'required',
            'budget' => 'required',
            'proposal' => 'mimes:pdf,docx|max:2048',
            'team_id' => 'required',
            'client_id' => 'required',
        ]);

        $dates = explode(' - ', $request->project_date);
        $start_date = Carbon::parse($dates[0]);
        $end_date = Carbon::parse($dates[1]);

        $file = $request->file('proposal');
        $proposal = $project->proposal;

        if ($proposalFile = $request->file('proposal')) {

            if ($oldFile = $project->proposal) {
                unlink(public_path('uploads/proposal/') . $oldFile);
            }

            $destinationPath = 'uploads/proposal';
            // $proposalName = date('YmdHis') . "_" . $proposalFile->getClientOriginalName() . "." .$proposalFile->getClientOriginalExtension();
            $proposalName1 = $proposalFile->getClientOriginalName();
            $proposalName2 = explode('.', $proposalName1)[0]; // Filename 'filename'
            $proposalName = $proposalName2 . "_" . date('YmdHis') . "." . $proposalFile->getClientOriginalExtension();
            $proposalFile->move($destinationPath, $proposalName);
            $file = "$proposalName";
        } else {
            unset($file);
        }

        $numbers = explode(',', $request->budget);
        $budget = (int)join('', $numbers);

        if (empty($file)) {
            $project->update([
                'name' => $request['name'],
                'email' => $request['email'],
                'title' => $request['title'],
                'description' => $request['description'],
                'budget' => $budget,
                'progress' => $request['progress'],
                'start_date' => $start_date,
                'end_date' => $end_date,
                'status' => $request->status,
                'category' => $request->category,
                'platform' => $request->platform,
                'proposal' => $proposal,
                'team_id' => $request['team_id'],
                'client_id' => $request['client_id'],
            ]);
        } else if ($project->status == 0) {
            $project->update([
                'name' => $request['name'],
                'email' => $request['email'],
                'title' => $request['title'],
                'description' => $request['description'],
                'budget' => $budget,
                'progress' => 0,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'category' => $request['category'],
                'platform' => $request['platform'],
                'proposal' => $proposalName,
                'team_id' => $request['team_id'],
                'client_id' => $request['client_id'],
            ]);
        } else if ($request->progress == 0) {
            $project->update([
                'name' => $request['name'],
                'email' => $request['email'],
                'title' => $request['title'],
                'description' => $request['description'],
                'budget' => $budget,
                'progress' => 0,
                'status' => 0,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'category' => $request['category'],
                'platform' => $request['platform'],
                'proposal' => $proposalName,
                'team_id' => $request['team_id'],
                'client_id' => $request['client_id'],
            ]);
        } else {
            $project->update([
                'name' => $request['name'],
                'email' => $request['email'],
                'title' => $request['title'],
                'description' => $request['description'],
                'budget' => $budget,
                'progress' => $request['progress'],
                'start_date' => $start_date,
                'end_date' => $end_date,
                'status' => $request->status,
                'category' => $request['category'],
                'platform' => $request['platform'],
                'proposal' => $proposalName,
                'team_id' => $request['team_id'],
                'client_id' => $request['client_id'],
            ]);
        }

        Notification::create([
            'detail' => $request->title . ' has been updated!',
            'type' => 0,
            'operation' => 1,
            'user_id' => Auth::user()->id,
            'team_id' => Auth::user()->currentTeam->id,
        ]);

        Alert::success('Success!', 'Data has been succesfully updated.');

        return redirect('/project');
    }

    public function downloadProposal(Project $project, $id)
    {
        $data = $project->where('id', $id)->first();
        $file = public_path("uploads/proposal/" . $data->proposal);
        return response()->download($file);
    }

    public function approve($id)
    {
        $project = Project::find($id);
        $team = Auth::user()->currentTeam;
        $user = Auth::user();
        
        if($project->team_id != $team->id){
            abort(403);
        } else {
            return view('pages.project.approval', compact('project')); 
        }
    }

    public function approveProject(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
        ]);

        $project = Project::find($id);
        $project->update([
            'status' => $request->status,
        ]);

        Alert::success('Success!', 'Status has been succesfully updated.');

        return redirect('/project');
    }
}
