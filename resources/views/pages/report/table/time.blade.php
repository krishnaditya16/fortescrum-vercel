@php
use Carbon\Carbon;
$timesheet = DB::table('timesheets')->where('id', $time->id)->first();
$startTime = Carbon::parse($timesheet->start_time);
$endTime = Carbon::parse($timesheet->end_time);
$interval = $endTime->diff($startTime)->format('%H:%I:%S');
@endphp

{{ $interval }}