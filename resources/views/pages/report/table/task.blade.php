@php
$task = DB::table('tasks')->where('id', $time->task_id)->first();
@endphp

@if(empty($task->title)) 
<span class="badge badge-danger" data-toggle="tooltip" title="Task got deleted by other user">Task ID : #{{$time->task_id}} Not found</span>
@else
{{ $task->title }}
@endif