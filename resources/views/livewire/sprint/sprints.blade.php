<h2 class="section-title">Sprints Data</h2>
<p class="section-lead mb-3">
    Overall sprints data from all project on your team are listed here.
</p>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <!-- <h4>Tambahin tombol create!</h4> -->
                <div class="card-header-action">
                    <a href="{{ route('sprint.create') }}" class="btn btn-icon icon-left btn-outline-dark"><i class="fas fa-plus"></i> Add Data</a>
                </div>
            </div>
            <div class="card-body">
                <livewire:sprint.sprint-table/>
            </div>
        </div>
    </div>
</div>