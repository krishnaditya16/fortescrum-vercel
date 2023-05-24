<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\Timesheet;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $project = Project::all();
        $client = Client::all();
        $user = User::all();
        $timesheets = Timesheet::all();

        $total_mnt = 0;
        $total_hour = 0;

        foreach($timesheets as $timesheet){
            $startTime = Carbon::parse($timesheet->start_time);
            $endTime = Carbon::parse($timesheet->end_time);
            $interval = $endTime->diff($startTime)->format('%H:%I:%S');
            $time =  explode(':', $interval);

            $total_mnt += (int)$time[1];
            $total_hour += (int)$time[0];
        }

        if($total_mnt >= 60){
            $total_hour += 1;
        }

        return view('landing.index', compact('user', 'client', 'project', 'total_hour'));
    }
}
