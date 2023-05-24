<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Sprint;
use App\Models\Backlog;
use App\Models\Project;
use App\Models\Timesheet;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use DateTime;
use DateInterval;
use DatePeriod;
use GuzzleHttp\Handler\Proxy;

class ReportController extends Controller
{
    public function index()
    {
        return view('pages.report.index');
    }

    public function sprintReport($id)
    {
        $project = Project::find($id);
        $backlogs = Backlog::where('project_id', $project->id)->get();
        $sprints = Sprint::where('project_id', $project->id)->get();
        $tasks = Task::where('project_id', $project->id)->get();

        $current_team = Auth::user()->currentTeam;
        $team = Jetstream::newTeamModel()->findOrFail($project->team_id);

        $data = [];

        foreach ($team->users as $user) {
            $data[] = $user->id;
        }

        $users = DB::table('team_user')
            ->join('users', 'team_user.user_id', 'users.id')
            ->whereIn('user_id', $data)->where('role', 'team-member')
            ->get();

        $total_member = count($users);

        if (empty($project) || $current_team->id != $project->team_id) {
            abort(403);
        }
        else {
            return view('pages.report.sprint-report', compact('project', 'backlogs', 'sprints', 'tasks', 'total_member'));
        }
    }

    public function timesheetReport($id)
    {
        $project = Project::find($id);
        $backlogs = Backlog::where('project_id', $project->id)->get();
        $sprints = Sprint::where('project_id', $project->id)->get();
        $tasks = Task::where('project_id', $project->id)->get();

        $current_team = Auth::user()->currentTeam;
        $team = Jetstream::newTeamModel()->findOrFail($project->team_id);

        $data = [];

        foreach ($team->users as $user) {
            $data[] = $user->id;
        }

        $users = DB::table('team_user')
            ->join('users', 'team_user.user_id', 'users.id')
            ->whereIn('user_id', $data)->where('role', 'team-member')
            ->get();

        $total_member = count($users);

        return view('pages.report.timesheet-report', compact('project', 'backlogs', 'sprints', 'tasks', 'total_member'));
    }

    public function efficiencyReport($id)
    {
        // // Calculate individual performance for each team member
        $project = Project::find($id);
        $team = Jetstream::newTeamModel()->findOrFail($project->team_id);
        $teamMembers = $team->users()->wherePivot('role', '<>', 'client-user')->get();
        // $performanceData = [];

        foreach ($teamMembers as $teamMember) {
            $completedTasks = Task::whereRaw("FIND_IN_SET($teamMember->id, assignee)")
                ->where('status', 1)
                ->get();
        }

        //     $totalTasks = count($completedTasks);
        //     $totalAllocatedHours = 0;
        //     $totalTasksWithTime = 0;
        //     $totalWorkDuration = 0;

        //     foreach ($completedTasks as $task) {
        //         $timesheets = Timesheet::where('task_id', $task->id)
        //             ->where('user_id', $teamMember->id)
        //             ->get();

        //         foreach ($timesheets as $timesheet) {
        //             $startTime = strtotime($timesheet->work_date . ' ' . $timesheet->start_time);
        //             $endTime = strtotime($timesheet->work_date . ' ' . $timesheet->end_time);
        //             $allocatedHours = ($endTime - $startTime) / 3600; // Convert to hours
        //             $totalAllocatedHours += $allocatedHours;
        //             $totalWorkDuration += ($endTime - $startTime);
        //         }

        //         $totalTasksWithTime += ($timesheets->count() > 0) ? 1 : 0;
        //     }

        //     $averageAllocatedHoursPerTask = ($totalTasksWithTime > 0) ? ($totalAllocatedHours / $totalTasksWithTime) : 0;

        //     $efficiency = 0;
        //     if ($totalTasks > 0) {
        //         $efficiency = ($totalWorkDuration / ($averageAllocatedHoursPerTask * $totalTasks * 3600)) * 100;
        //     }

        //     $taskCompletionRate = ($totalTasks > 0) ? ($totalTasksWithTime / $totalTasks) * 100 : 0;

        //     // Calculate the performance score based on the factors
        //     $performance = ($efficiency * 0.7) + ($taskCompletionRate * 0.3);

        //     $performanceData[] = [
        //         'teamMember' => $teamMember,
        //         'performance' => $performance,
        //     ];
        // }

        // Sort the performance data based on performance score
        // usort($performanceData, function ($a, $b) {
        //     return $b['performance'] <=> $a['performance'];
        // });

        // Calculate flow efficiency for each completed task
        $flowEfficiencyData = [];
        foreach ($completedTasks as $task) {
            $timesheets = Timesheet::where('task_id', $task->id)->get();
            $totalWorkDuration = 0;
            $totalWaitDuration = 0;
            $workDurationHours = 0;

            foreach ($timesheets as $timesheet) {
                $startTime = strtotime($timesheet->work_date . ' ' . $timesheet->start_time);
                $endTime = strtotime($timesheet->work_date . ' ' . $timesheet->end_time);
                $workDurationHours = ($endTime - $startTime) / 3600; // Convert work duration to hours
                $totalWorkDuration += $workDurationHours;
            }

            // Convert task duration to days
            $taskDurationDays = (strtotime($task->end_date) - strtotime($task->start_date)) / (24 * 3600);

            // Calculate wait duration (assuming wait time is the difference between task duration and actual work time)
            $waitDurationDays = $taskDurationDays - $totalWorkDuration / 8; // Assuming a working day is 8 hours

            $flowEfficiency = ($totalWorkDuration / ($totalWorkDuration + $waitDurationDays * 8)) * 100;

            $flowEfficiencyData[] = [
                'task' => $task,
                'flowEfficiency' => $flowEfficiency,
                'taskDurationDays' => $taskDurationDays,
                'totalWorkDuration' => $totalWaitDuration,
                'waitDurationDays' => $waitDurationDays,
                'workDurationHours' => $workDurationHours
            ];
        }

        // Sort the flow efficiency data based on flow efficiency score
        usort($flowEfficiencyData, function ($a, $b) {
            return $b['flowEfficiency'] <=> $a['flowEfficiency'];
        });

        return view('pages.report.efficiency-report', compact('project', 'flowEfficiencyData'));
    }

    public function sprintBurndown($id, $sprint_id)
    {
        // Retrieve data from the Sprint and Backlog tables
        $projects = Project::findOrFail($id);
        $sprints = Sprint::findOrFail($sprint_id);
        $backlogs = Backlog::where('sprint_id', $sprint_id)->get();

        // Perform calculations and data processing for the burndown chart
        $startDate = $sprints->start_date;
        $endDate = $sprints->end_date;
        $totalSp = $sprints->total_sp;

        $chartData = [];
        $remainingSp = $totalSp;
        $date = $startDate;

        while ($date <= $endDate) {
            $dailySp = 0;
            foreach ($backlogs as $backlog) {
                if ($backlog->created_at->format('Y-m-d') == $date) {
                    $dailySp += $backlog->story_point;
                }
            }
            $remainingSp -= $dailySp;

            // Ensure remaining story points do not go below zero
            $remainingSp = max(0, $remainingSp);

            $chartData[] = [
                'date' => $date,
                'remaining_sp' => $remainingSp,
            ];

            $date = date('Y-m-d', strtotime($date . '+1 day'));
        }

        // Calculate the ideal burndown data
        $idealBurndownData = [];
        $idealStartDate = $startDate;
        $idealEndDate = $endDate;

        $chartDataCount = count($chartData);
        $idealSpPerDay = $totalSp / ($chartDataCount - 1); // Subtract 1 to exclude the last day

        $idealRemainingSp = $totalSp;

        foreach ($chartData as $index => $data) {
            $idealDate = $data['date'];
            $idealBurndownData[] = [
                'date' => $idealDate,
                'remaining_sp' => $idealRemainingSp,
            ];

            if ($index < $chartDataCount - 1) {
                $idealRemainingSp -= $idealSpPerDay;
                // Ensure remaining story points do not go below zero
                $idealRemainingSp = max(0, $idealRemainingSp);
            }
        }

        // Set the remaining story points to 0 at the end of the sprint
        $idealBurndownData[] = [
            'date' => $endDate,
            'remaining_sp' => 0,
        ];

        // Pass the processed data to the Blade template
        return view('pages.report.sprint-burndown', compact('projects', 'sprints', 'backlogs', 'chartData', 'idealBurndownData'));
    }
}
