<?php

namespace App\Http\Controllers;

use App\Mail\MeetingMailOffline;
use App\Mail\MeetingMailOnline;
use App\Models\Meeting;
use App\Models\Project;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;

class MeetingController extends Controller
{
    public function index()
    {
        return view('pages.meeting.index');
    }

    public function meetingProject($id)
    {
        $project = Project::find($id);
        $meetings = Meeting::where('project_id', $id)->get()->toJson();

        return view('pages.meeting.project-meeting', compact('project', 'meetings'));
    }

    public function createMeeting($id)
    {
        $project = Project::find($id);
        return view('pages.meeting.create-meeting', compact('project'));
    }

    public function storeMeeting(Request $request) 
    {
        $start_time = date("H:i:s", strtotime($request->start_time));
        $end_time = date("H:i:s", strtotime($request->end_time));

        $team = Team::where('id', $request->team_id)->first();
        $users = $team->allUsers();
        $project = Project::where('id', $request->project_id)->first();

        if($request->type == "0"){
            $request->validate([
                'title' => 'required|min:3|max:30',
                'meeting_date' => 'required',
                'start_time' => 'required',
                'end_time' => 'required',
                'type' => 'required',
                'project_id' => 'required',
                'team_id' => 'required',
                'meeting_location' => 'required',
            ]);
            Meeting::create([
                'title' => $request->title,
                'meeting_date' => $request->meeting_date,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'type' => $request->type,
                'meeting_location' => $request->meeting_location,
                'project_id' => $request->project_id,
                'team_id' => $request->team_id
            ]);

            $type = "Offline";
            $details = [
                'title' => 'New Meeting for '.$project->title,
                'url' => 'http://127.0.0.1:8000/project/'.$request->project_id.'/meeting',
                'meeting' => $request->title,
                'meeting_date' => $request->meeting_date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'type' => $type,
                'meeting_location' => $request->meeting_location,
                'from_mail' => $request->from_mail,
                'mail_sender' => $request->mail_sender,
            ];
            
            foreach($users as $user){
                Mail::to($user->email)->send(new MeetingMailOffline($details));
            }

        } else if($request->type == "1"){
            $request->validate([
                'title' => 'required|min:3|max:30',
                'meeting_date' => 'required',
                'start_time' => 'required',
                'end_time' => 'required',
                'type' => 'required',
                'project_id' => 'required',
                'team_id' => 'required',
                'meeting_link' => 'required',
            ]);
            Meeting::create([
                'title' => $request->title,
                'meeting_date' => $request->meeting_date,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'type' => $request->type,
                'meeting_link' => $request->meeting_link,
                'project_id' => $request->project_id,
                'team_id' => $request->team_id
            ]);

            $type = "Online";
            $details = [
                'title' => 'New Meeting for '.$project->title,
                'url' => 'http://127.0.0.1:8000/project/'.$request->project_id.'/meeting',
                'meeting' => $request->title,
                'meeting_date' => $request->meeting_date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'type' => $type,
                'meeting_link' => $request->meeting_link,
                'from_mail' => $request->from_mail,
                'mail_sender' => $request->mail_sender,
            ];
            
            foreach($users as $user){
                Mail::to($user->email)->send(new MeetingMailOnline($details));
            }
        }

        Alert::success('Success!', 'Meeting data has been succesfully created.');
        $project_id = $request->project_id;
        return redirect()->route('project.meeting', $project_id);
    }

    public function editMeeting($id, Meeting $meeting)
    {
        $project = Project::find($id);
        $current_team = Auth::user()->currentTeam;

        if (empty($project) || $current_team->id != $project->team_id) {
            abort(403);
        } else {
            return view('pages.meeting.edit-meeting', compact('meeting', 'project'));
        }
    }

    public function updateMeeting(Request $request)
    {
        $start_time = date("H:i:s", strtotime($request->start_time));
        $end_time = date("H:i:s", strtotime($request->end_time));
        $meeting = Meeting::where('id', $request->meeting_id);

        if($request->type == "0"){
            $request->validate([
                'title' => 'required|min:3|max:30',
                'meeting_date' => 'required',
                'start_time' => 'required',
                'end_time' => 'required',
                'type' => 'required',
                'project_id' => 'required',
                'team_id' => 'required',
                'meeting_location' => 'required',
            ]);
            $meeting->update([
                'title' => $request->title,
                'meeting_date' => $request->meeting_date,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'type' => $request->type,
                'meeting_link' => null,
                'meeting_location' => $request->meeting_location,
                'project_id' => $request->project_id,
                'team_id' => $request->team_id
            ]);

        } else if($request->type == "1"){
            $request->validate([
                'title' => 'required|min:3|max:30',
                'meeting_date' => 'required',
                'start_time' => 'required',
                'end_time' => 'required',
                'type' => 'required',
                'project_id' => 'required',
                'team_id' => 'required',
                'meeting_link' => 'required',
            ]);
            $meeting->update([
                'title' => $request->title,
                'meeting_date' => $request->meeting_date,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'type' => $request->type,
                'meeting_link' => $request->meeting_link,
                'meeting_location' => null,
                'project_id' => $request->project_id,
                'team_id' => $request->team_id
            ]);
        }

        Alert::success('Success!', 'Meeting data has been succesfully updated.');
        $project_id = $request->project_id;
        return redirect()->route('project.meeting', $project_id);
    }
}
