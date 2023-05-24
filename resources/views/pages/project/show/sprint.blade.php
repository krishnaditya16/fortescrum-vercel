<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>{{ $project->title }} - Sprints</h4>
                <div class="card-header-action">
                    <a href="{{ route('project.sprint.create', $project->id) }}" class="btn btn-icon icon-left btn-outline-dark"><i class="fas fa-plus"></i> Add Data</a>
                    <button class="btn btn-outline-dark" type="button" data-toggle="tooltip" title="Total Story Point : (Total Team Member * Sprint Length) * Focus Factor">
                        <i class="fas fa-exclamation-circle"></i> Story Point
                    </button>
                    <button class="btn btn-outline-dark" type="button" data-toggle="tooltip" title="If a new team member is added, please edit the previous sprint data to get correct total story point calculation.">
                        <i class="fas fa-sticky-note"></i> Notes
                    </button>
                </div>
            </div>

            @livewire('sprint.sprint-project', ['project' => $project])

        </div>
    </div>
</div>