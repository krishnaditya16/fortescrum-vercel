<div class="dropdown">
    <a href="#" data-toggle="dropdown" class="btn btn-outline-dark dropdown-toggle">Options</a>
    <div class="dropdown-menu">
        <a href="/project/{{ $project->id }}/sprint-reports" class="dropdown-item has-icon"><i class="fas fa-file-alt"></i> Sprints Report</a>
        <a href="/project/{{ $project->id }}/timesheet-reports" class="dropdown-item has-icon"><i class="fas fa-clock"></i> Timesheets Report</a>
        <a href="/project/{{ $project->id }}/efficiency-reports" class="dropdown-item has-icon"><i class="fas fa-cogs"></i> Efficiency Report</a>
    </div>
</div>
