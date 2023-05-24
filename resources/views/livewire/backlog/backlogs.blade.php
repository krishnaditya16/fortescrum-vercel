<h2 class="section-title">Backlog Data</h2>
<p class="section-lead mb-3">
    Overall backlogs data from all project on your team are listed here.
</p>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-header-action">
                    <a href="{{ route('backlog.create') }}" class="btn btn-icon icon-left btn-outline-dark"><i class="fas fa-plus"></i> Add Data</a>
                </div>
            </div>
            <div class="card-body">
                <livewire:backlog.backlog-table/>
            </div>
        </div>
    </div>
</div>