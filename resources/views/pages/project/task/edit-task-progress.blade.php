<x-app-layout>
    <x-slot name="title">{{ __('Edit Task Progress') }} - {{ $projects->title }}</x-slot>
    <x-slot name="header_content">
        <div class="section-header-back">
            <a href="{{ url()->previous() }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ __('Edit Task Progress') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('project.index') }}">Project</a></div>
            <div class="breadcrumb-item active"><a href="../{{ $projects->id }}">#{{ $projects->id }}</a></div>
            <div class="breadcrumb-item">Edit Task Progress</div>
        </div>
    </x-slot>

    <h2 class="section-title">Edit Task Progress</h2>
    <p class="section-lead mb-3">
        On this page you can edit progress of a task and view the task timeline.
    </p>

    <div class="row">

        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Task Progress</h4>
                    <div class="card-header-action">
                        @if($task->progress !== 100)
                        <a href="#" class="btn btn-secondary" data-toggle="tooltip" title="Action is disabled! (Task progress is not 100% yet)"><i class="fas fa-check"></i> Mark as Done</a>
                        @elseif($task->progress == 100 && $task->status == 1)
                        <a href="#" class="btn btn-success" data-toggle="tooltip" title="Task is finished"><i class="fas fa-check"></i> Finished</a>
                        @else
                        <form action="{{ route('project.task.status', ['id'=>$projects->id, 'task'=>$task->id]) }}" method="post" id="doneTask">
                            @csrf
                            @method('PUT')
                            <input type="hidden" value="1" name="status">
                            <a href="#" class="btn btn-success" data-confirm="Are You Sure?|This task will be marked as done. Do you want to continue?" data-confirm-yes="document.getElementById('doneTask').submit();">
                                <i class="fas fa-check"></i> Mark as Done 
                            </a>
                        </form>
                        @endif
                    </div>
                </div>
                <div class="card-body">

                    <form action="{{ route('project.task.progress.update', ['id' => $projects->id, 'task' => $task->id]) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Progress : <output name="progress" id="progressOutputId">{{ $task->progress }}</output>%</label>
                            <div class="col-sm-12 col-md-7">
                            <input type="range" class="form-control" name="task_progress" id="progressInputId" value="{{ $task->progress }}" min="0" max="100" oninput="progressOutputId.value = progressInputId.value">
                                @error('progress') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="form-group row mb-1">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Notes</label>
                            <div class="col-sm-12 col-md-7">
                                <textarea class="summernote-simple" name="notes">{{ old('notes') }}</textarea>
                                @error('notes') <span class="text-red-500 mb-4">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <button type="submit" class="btn btn-primary">Update Data</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>Task Timeline</h4>
                </div>
                <div class="card-body">
                    <div class="activities">
                        @if($task->status == 1)
                        <div class="activity">
                            <div class="activity-icon bg-primary text-white shadow-primary">
                                <i class="fas fa-arrows-alt"></i>
                            </div>
                            <div class="activity-detail">
                                <div class="mb-2">
                                    <span class="text-job text-primary">{{ $task->updated_at->diffForHumans() }}</span>
                                </div>
                                <p>Task has been move to finished task</p>
                            </div>
                        </div>
                        @endif
                        @foreach($timelines as $timeline)
                        <div class="activity">
                            <div class="activity-icon bg-primary text-white shadow-primary">
                                <i class="fas fa-comment-alt"></i>
                            </div>
                            <div class="activity-detail">
                                <div class="mb-2">
                                    <span class="text-job text-primary">{{ $timeline->created_at->diffForHumans() }}</span>
                                </div>
                                @php 
                                    $assignee = DB::table('users')->find($timeline->user_id);
                                @endphp
                                <p>Task progress has been updated to <span class="text-timeline">{{ $timeline->current_progress }}%</span> by <span class="text-timeline">{{ $assignee->name }}</span></p>
                                <h5 class="mt-1">Notes:</h5>
                                <p>{!! $timeline->notes !!}</p>
                            </div>
                        </div>
                        @endforeach
                        <div class="activity">
                            <div class="activity-icon bg-primary text-white shadow-primary">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="activity-detail">
                                <div class="mb-2">
                                    <span class="text-job text-primary">{{ $task->created_at->diffForHumans() }}</span>
                                </div>
                                <p>Assigned the task to
                                    @foreach ($users as $key => $user)
                                        <span class="text-timeline">{{ $user->name }}</span>@if ($key !== count($users) - 1),@endif
                                    @endforeach
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>